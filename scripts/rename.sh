#!/usr/bin/env bash
# scripts/rename-posts-and-images.sh
# Usage:
#   ./scripts/rename-posts-and-images.sh         -> LIVE mode (git mv + commit)
#   ./scripts/rename-posts-and-images.sh --dry   -> dry run (preview only)
set -euo pipefail

DRY=0
if [[ "${1:-}" == "--dry" || "${1:-}" == "-n" ]]; then
  DRY=1
fi

# Helper: make safe slug from arbitrary text
slugify() {
  local s="$1"
  s="${s,,}"                                 # to lower
  s="$(echo "$s" | iconv -f utf8 -t ascii//TRANSLIT 2>/dev/null || cat)" # transliterate if available
  s="$(echo "$s" | sed -E 's/[^a-z0-9]+/-/g')" # non-alnum -> -
  s="$(echo "$s" | sed -E 's/^-+|-+$//g')"     # trim leading/trailing -
  s="$(echo "$s" | sed -E 's/-{2,}/-/g')"     # collapse multiple -
  echo "$s"
}

# Get commit date for a file as YYYY-MM-DD-HHMM (fallback)
commit_date_prefix() {
  local file="$1"
  local gitdate
  gitdate=$(git log -1 --format="%ci" -- "$file" 2>/dev/null || true)
  if [[ -z "$gitdate" ]]; then
    date +"%Y-%m-%d-%H%M"
  else
    date -d "$gitdate" +"%Y-%m-%d-%H%M"
  fi
}

# Try to extract a prefix from filename if it already contains a date
# Returns prefix||remainder (use IFS='||' read -r prefix remainder <<< ...)
extract_prefix_from_name() {
  local name="$1"
  # Case: YYYY-MM-DD(-HHMM...)-rest
  if [[ "$name" =~ ^([0-9]{4})-([0-9]{2})-([0-9]{2})(-([0-9]{4,6}))[-_]*(.+)$ ]]; then
    local y=${BASH_REMATCH[1]}; local m=${BASH_REMATCH[2]}; local d=${BASH_REMATCH[3]}
    local timet=${BASH_REMATCH[5]}; local rest=${BASH_REMATCH[6]}
    if [[ -n "$timet" ]]; then
      local hhmm=${timet:0:4}
      echo "${y}-${m}-${d}-${hhmm}||${rest}"
      return 0
    else
      echo "${y}-${m}-${d}||${rest}"
      return 0
    fi
  fi

  # Case: DD-MM-YYYY rest (e.g. radar-25-12-2025-1766...)
  if [[ "$name" =~ ([0-9]{2})-([0-9]{2})-([0-9]{4})[-_]*(.*)$ ]]; then
    local dd=${BASH_REMATCH[1]}; local mm=${BASH_REMATCH[2]}; local yyyy=${BASH_REMATCH[3]}
    local rest=${BASH_REMATCH[4]}
    if [[ -n "$rest" ]]; then
      if [[ "$rest" =~ ([0-9]{4,6}) ]]; then
        local t=${BASH_REMATCH[1]}; local hhmm=${t:0:4}
        echo "${yyyy}-${mm}-${dd}-${hhmm}||${rest}"
        return 0
      else
        echo "${yyyy}-${mm}-${dd}||${rest}"
        return 0
      fi
    else
      echo "${yyyy}-${mm}-${dd}||${name}"
      return 0
    fi
  fi

  # nothing parseable
  echo "||${name}"
  return 0
}

plan=()

process_file() {
  local filepath="$1"
  local dir
  dir=$(dirname "$filepath")
  local base
  base=$(basename "$filepath")
  local ext="${base##*.}"
  local name="${base%.*}"

  IFS='||' read -r prefix remainder <<< "$(extract_prefix_from_name "$name")"

  if [[ -z "$prefix" ]]; then
    prefix="$(commit_date_prefix "$filepath")"
  fi

  local slug="${remainder:-$name}"
  slug="$(slugify "$slug")"
  if [[ -z "$slug" ]]; then
    slug="$(slugify "$name")"
  fi

  local newname="${prefix}-${slug}.${ext}"
  newname="$(echo "$newname" | sed -E 's/-{2,}/-/g')"

  if [[ "$base" != "$newname" ]]; then
    plan+=("$filepath -> $dir/$newname")
  fi
}

# Gather files
for f in posts/*; do
  [[ -f "$f" ]] || continue
  process_file "$f"
done

for f in images/*; do
  [[ -f "$f" ]] || continue
  process_file "$f"
done

if [[ ${#plan[@]} -eq 0 ]]; then
  echo "No renames necessary (already following pattern)."
  exit 0
fi

echo "Planned renames (${#plan[@]}):"
for p in "${plan[@]}"; do
  echo "  $p"
done

if [[ $DRY -eq 1 ]]; then
  echo ""
  echo "[DRY RUN] No changes made. Re-run without --dry to apply."
  exit 0
fi

echo ""
echo "Applying renames..."
for p in "${plan[@]}"; do
  oldpath="${p%% -> *}"
  newpath="${p##* -> }"
  mkdir -p "$(dirname "$newpath")"
  echo "git mv -- \"$oldpath\" \"$newpath\""
  git mv -- "$oldpath" "$newpath"
done

# Commit as a single grouped change
git add -A
git commit -m "refactor: standardize posts/ and images/ filenames to YYYY-MM-DD(-HHMM)-descriptive-name"
echo "✓ Committed renames. Inspect with: git show --name-only HEAD"
echo "Next: git push origin $(git rev-parse --abbrev-ref HEAD)"