# Rename mapping for images folder - Format B: YYYY-MM-DD(-HHMM)-descriptive-name.ext
$imageFolder = Split-Path -Parent $PSScriptRoot

$renameMap = @{
    "radar-25-12-2025-1766716220440.png" = "2025-12-25-radar.png"
    "rdc-IAM-2025-12-26-1766722057930.png" = "2025-12-26-1767-rdc-iam.png"
    "rdc-IAM-2025-12-26-1766722437416.png" = "2025-12-26-1766-rdc-iam-2.png"
    "rdc-IAM-2025-12-26.png" = "2025-12-26-rdc-iam.png"
    "rdc-IAM-2025-12-28-1766957495723.png" = "2025-12-28-1766-rdc-iam.png"
    "rdc-IAM-2025-12-29-1767037420412.png" = "2025-12-29-1767-rdc-iam.png"
    "rdc-briefing-2025-12-25.jpg" = "2025-12-25-rdc-briefing.jpg"
    "rdc-briefing-2025-12-25.png" = "2025-12-25-rdc-briefing.png"
    "rdc-briefing-2025-12-26-a-autentica-o-multifator-deix.png" = "2025-12-26-rdc-briefing-a-autentica-o-multifator.png"
    "rdc-briefing-2025-12-26-a-infraestrutura-de-confian-a.png" = "2025-12-26-rdc-briefing-a-infraestrutura-de-confian-a.png"
    "rdc-briefing-2025-12-26-achar-que-mfa-resolve-tudo-u.png" = "2025-12-26-rdc-briefing-achar-que-mfa-resolve-tudo.png"
    "rdc-briefing-2025-12-26-se-o-seu-foco-est-apenas-em-u.png" = "2025-12-26-rdc-briefing-se-o-seu-foco-est-apenas-em.png"
    "rdc-briefing-2025-12-26-sua-estrat-gia-de-iam-falha-qu.png" = "2025-12-26-rdc-briefing-sua-estrat-gia-de-iam-falha.png"
    "rdc-briefing-2025-12-26.jpg" = "2025-12-26-rdc-briefing.jpg"
    "rdc-briefing-2025-12-26.png" = "2025-12-26-rdc-briefing.png"
    "rdc-business-2026-01-04-020817.png" = "2026-01-04-0208-rdc-business.png"
    "rdc-business-2026-01-08-184327.png" = "2026-01-08-1843-rdc-business.png"
    "rdc-business-2026-01-23-232942.png" = "2026-01-23-2329-rdc-business.png"
    "rdc-business-2026-01-27-145002.png" = "2026-01-27-1450-rdc-business.png"
    "rdc-business-2026-02-09-122246.png" = "2026-02-09-1222-rdc-business.png"
    "rdc-business-2026-02-09-170323.png" = "2026-02-09-1703-rdc-business.png"
    "rdc-business-exec-2025-12-26.jpg" = "2025-12-26-rdc-business-exec.jpg"
    "rdc-business-exec-2025-12-29-1639.jpg" = "2025-12-29-1639-rdc-business-exec.jpg"
    "rdc-consult-2025-12-26-011059.jpg" = "2025-12-26-0110-rdc-consult.jpg"
    "rdc-consult-2025-12-26-011735.jpg" = "2025-12-26-0117-rdc-consult.jpg"
    "rdc-consult-2025-12-26-013937.jpg" = "2025-12-26-0139-rdc-consult.jpg"
    "rdc-consult-2025-12-26.jpg" = "2025-12-26-rdc-consult.jpg"
    "rdc-cover-2025-12-25.png" = "2025-12-25-rdc-cover.png"
    "rdc-cyber-2025-12-26.png" = "2025-12-26-rdc-cyber.png"
    "rdc-cyber-2025-12-29-164229.png" = "2025-12-29-1642-rdc-cyber.png"
    "rdc-cyber-2025-12-30-001132.png" = "2025-12-30-0011-rdc-cyber.png"
    "rdc-cyber-2025-12-31-235703.png" = "2025-12-31-2357-rdc-cyber.png"
    "rdc-cyber-2026-01-02-232651.png" = "2026-01-02-2326-rdc-cyber.png"
    "rdc-cyber-2026-01-04-020553.png" = "2026-01-04-0205-rdc-cyber.png"
    "rdc-cyber-2026-01-04-020936.png" = "2026-01-04-0209-rdc-cyber.png"
    "rdc-cyber-2026-01-04-021217.png" = "2026-01-04-0212-rdc-cyber.png"
    "rdc-cyber-2026-01-05-163701.png" = "2026-01-05-1637-rdc-cyber.png"
    "rdc-cyber-2026-01-08-183317.png" = "2026-01-08-1833-rdc-cyber.png"
    "rdc-cyber-2026-01-08-184313.png" = "2026-01-08-1843-rdc-cyber.png"
    "rdc-cyber-2026-01-08-184318.png" = "2026-01-08-1843-rdc-cyber-b.png"
    "rdc-cyber-2026-01-08-184322.png" = "2026-01-08-1843-rdc-cyber-c.png"
    "rdc-cyber-2026-01-08-184333.png" = "2026-01-08-1843-rdc-cyber-d.png"
    "rdc-cyber-2026-01-13-233815.png" = "2026-01-13-2338-rdc-cyber.png"
    "rdc-cyber-2026-01-14-201115.png" = "2026-01-14-2011-rdc-cyber.png"
    "rdc-cyber-2026-01-20-192139.png" = "2026-01-20-1921-rdc-cyber.png"
    "rdc-cyber-2026-01-21-082147.png" = "2026-01-21-0821-rdc-cyber.png"
    "rdc-cyber-2026-01-27-144545.png" = "2026-01-27-1445-rdc-cyber.png"
    "rdc-cyber-2026-01-27-145457.png" = "2026-01-27-1454-rdc-cyber.png"
    "rdc-cyber-2026-01-27-152716.png" = "2026-01-27-1527-rdc-cyber.png"
    "rdc-cyber-2026-01-30-111552.png" = "2026-01-30-1115-rdc-cyber.png"
    "rdc-cyber-2026-02-09-122507.png" = "2026-02-09-1225-rdc-cyber.png"
    "rdc-cyber-2026-02-09-122510.png" = "2026-02-09-1225-rdc-cyber-b.png"
    "rdc-cyber-2026-02-09-122513.png" = "2026-02-09-1225-rdc-cyber-c.png"
    "rdc-cyber-2026-02-09-122516.png" = "2026-02-09-1225-rdc-cyber-d.png"
    "rdc-cyber-2026-02-09-122519.png" = "2026-02-09-1225-rdc-cyber-e.png"
    "rdc-cyber-2026-02-09-151828.png" = "2026-02-09-1518-rdc-cyber.png"
    "rdc-cyber-2026-02-09-161428.png" = "2026-02-09-1614-rdc-cyber.png"
    "rdc-cyber-2026-02-09-161847.png" = "2026-02-09-1618-rdc-cyber.png"
    "rdc-cyber-2026-02-09-radar-do-cadu-a-era-da-execucao-industrial.png" = "2026-02-09-rdc-cyber-radar-do-cadu-a-era-da-execucao-industrial.png"
    "rdc-tech-2025-12-26-0420.png" = "2025-12-26-0420-rdc-tech.png"
    "rdc-tech-2025-12-26-1608.png" = "2025-12-26-1608-rdc-tech.png"
    "rdc-tech-2025-12-26.png" = "2025-12-26-rdc-tech.png"
    "rdc-tech-2025-12-29-1938.png" = "2025-12-29-1938-rdc-tech.png"
}

$imagesPath = Join-Path $PSScriptRoot "images"
$successCount = 0
$errorCount = 0

Write-Host "Starting image rename operation..."
Write-Host "Target folder: $imagesPath"
Write-Host "Total files to rename: $($renameMap.Count)`n"

foreach ($oldName in $renameMap.Keys) {
    $newName = $renameMap[$oldName]
    $oldPath = Join-Path $imagesPath $oldName
    $newPath = Join-Path $imagesPath $newName
    
    if (Test-Path $oldPath) {
        try {
            Rename-Item -Path $oldPath -NewName $newName -ErrorAction Stop
            Write-Host "✓ $oldName → $newName" -ForegroundColor Green
            $successCount++
        }
        catch {
            Write-Host "✗ Failed to rename $oldName : $_" -ForegroundColor Red
            $errorCount++
        }
    }
    else {
        Write-Host "⊘ File not found: $oldName" -ForegroundColor Yellow
        $errorCount++
    }
}

Write-Host "`n========================================" -ForegroundColor Cyan
Write-Host "Rename operation completed!" -ForegroundColor Cyan
Write-Host "Success: $successCount | Errors: $errorCount" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
