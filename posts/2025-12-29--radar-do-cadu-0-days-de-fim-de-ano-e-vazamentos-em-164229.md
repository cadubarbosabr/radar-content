---
title: "Radar do Cadu: 0-Days de Fim de Ano e Vazamentos em Massa"
category: "Cyber"
image: "images/2026-02-10--rdc-cyber-164229.png"
date: "29 dez 2025"
author: "Cadu Barbosa"
excerpt: "Briefing 29/12: Alerta máximo para 0-days ativos em Cisco, Windows, Chrome e Android; vazamentos massivos de PII e ataque à Ubisoft."
---

## 🛡️ Destaques da Semana

### 0-Day Crítico Cisco AsyncOS: APT Chinês Ativo
`CVE-2025-20393, 0-DAY, APT`

- **O Fato:** Uma vulnerabilidade crítica de dia zero (CVE-2025-20393, CVSS 10.0) no Cisco AsyncOS está sendo ativamente explorada pelo APT UAT-9686. A CISA adicionou-a ao KEV com prazo de remediação até 24/12.
- **O Ruído:** O pânico sobre a origem chinesa do APT e a pontuação CVSS máxima, sem focar na ação.
- **O Sinal:** RCE com privilégios de root em Cisco Secure Email Gateway/Web Manager. Vetor de ataque direto e alto impacto.
- **🔴 Ação:** Patcheie imediatamente todos os dispositivos Cisco Secure Email Gateway (SEG) e Secure Email e Web Manager (SEWM). Monitore logs para atividades anômalas.

### Zero-Day de EoP no Windows Cloud Files Corrigido
`0-DAY, WINDOWS, EoP`

- **O Fato:** Microsoft corrigiu uma vulnerabilidade de dia zero (CVE-2025-62221) no Windows Cloud Files Mini Filter Driver. A falha permitia escalada de privilégios e estava sendo ativamente explorada.
- **O Ruído:** O alarde sobre 'mais um 0-day da Microsoft' sem contextualizar o impacto real.
- **O Sinal:** Exploração ativa para escalada de privilégios em sistemas Windows, indicando um vetor para ataques mais amplos.
- **🔴 Ação:** Aplique as atualizações de segurança de dezembro de 2025 da Microsoft para todos os sistemas Windows. Revise logs de segurança para sinais de exploração prévia.

### Google Corrige Oitavo Zero-Day do Chrome em 2025
`0-DAY, CHROME, BROWSER`

- **O Fato:** Google lançou uma atualização de segurança para o Chrome corrigindo uma falha de alta gravidade (issue 466192044) já explorada em ataques reais. É o oitavo 0-day do Chrome em 2025.
- **O Ruído:** A contagem de 0-days como métrica de falha do Chrome, ignorando a complexidade do software.
- **O Sinal:** Exploração ativa de vulnerabilidade no navegador, um ponto de entrada comum para comprometimento de endpoints.
- **🔴 Ação:** Atualize imediatamente todos os navegadores Google Chrome para a versão mais recente. Implemente políticas de atualização automática.

### Android: Duas Zero-Days Críticas no Catálogo KEV da CISA
`0-DAY, ANDROID, CISA KEV`

- **O Fato:** Duas falhas de dia zero no Android (CVE-2025-48633 e CVE-2025-48572), permitindo divulgação de informações e EoP, foram ativamente exploradas. CISA adicionou-as ao KEV com prazo até 23/12.
- **O Ruído:** O foco no número de CVEs sem detalhar o impacto prático.
- **O Sinal:** Exploração ativa de dispositivos Android, comprometendo a privacidade e a integridade do sistema.
- **🔴 Ação:** Garanta que todos os dispositivos Android na sua organização recebam as atualizações de segurança de dezembro de 2025. Monitore dispositivos móveis para comportamento suspeito.

### Vazamento de Dados na 700Credit Expõe 5.6 Milhões de Indivíduos
`DATA BREACH, PII, VAZAMENTO`

- **O Fato:** A 700Credit divulgou um vazamento de dados em 22/12/2025, expondo informações pessoais sensíveis de pelo menos 5.6 milhões de indivíduos, coletadas de concessionárias de automóveis.
- **O Ruído:** O sensacionalismo sobre o grande número de registros e o tipo de dados expostos.
- **O Sinal:** Comprometimento de PII altamente sensível (SSN, detalhes financeiros) de clientes, gerando risco de fraude e roubo de identidade.
- **🔴 Ação:** Avalie sua cadeia de suprimentos e parceiros que lidam com dados sensíveis. Reforce a segurança de APIs e acessos de terceiros. Notifique clientes afetados e ofereça monitoramento de crédito.

### Ubisoft: Ataque Massivo ao Rainbow Six Siege e Suborno de Suporte
`GAMING, HACK, DATA BREACH, SOCIAL ENGINEERING`

- **O Fato:** Servidores de Tom Clancy's Rainbow Six Siege foram desligados em 27/12/2025 após um ataque hacker. Relatos indicam que subornos no suporte da Ubisoft podem ter contribuído.
- **O Ruído:** O drama do jogo estar offline e a especulação sobre a extensão do ataque.
- **O Sinal:** Comprometimento de infraestrutura de jogos e potencial engenharia social/suborno no suporte, indicando falhas humanas e sistêmicas.
- **🔴 Ação:** Audite controles de acesso e processos de suporte ao cliente para prevenir engenharia social. Reforce a segurança de infraestruturas críticas e APIs.

### Análise do Patch Tuesday de Dezembro: 57 Vulnerabilidades Corrigidas
`PATCH TUESDAY, VULNERABILITIES, MICROSOFT`

- **O Fato:** As atualizações de segurança da Microsoft de dezembro de 2025 abordaram 57 vulnerabilidades, incluindo três críticas e seis 'mais prováveis de exploração'. Afetam Office, SharePoint e Copilot.
- **O Ruído:** A lista exaustiva de CVEs sem priorização.
- **O Sinal:** Várias vulnerabilidades críticas em produtos Microsoft amplamente utilizados, exigindo atenção imediata para evitar exploração.
- **🔴 Ação:** Priorize a aplicação dos patches de dezembro da Microsoft, com foco nas CVEs críticas e as de 'exploração mais provável', especialmente em Office, SharePoint e Copilot.

---

## 📜 Contexto Histórico

**2025 // Balaji Srinivasan: A Era da Privacidade Global em Cripto**
Em 29 de dezembro de 2025, Balaji Srinivasan, ex-CTO da Coinbase, declarou que a indústria de criptomoedas entra em sua terceira fase, focada na privacidade global e na ascensão das Zero-Knowledge Proofs (ZK-proofs) como infraestrutura central.

> 💡 *Lição: A evolução da segurança e privacidade é constante, mesmo em setores emergentes. ZK-proofs são um lembrete da necessidade de inovar em defesa e proteção de dados, antecipando as próximas fronteiras da cibersegurança.*

---

> "Só há dois tipos de empresas no mundo: as que foram violadas e sabem disso e as que foram violadas e não sabem disso."
>
> — **Ted Schlein**