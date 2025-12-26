---
title: "Zero-Days, Ransomware e Multas: O Fim de Ano Não Perdoa"
category: "Cyber"
image: "images/rdc-cyber-2025-12-26-012559.png"
date: "26 dez 2025"
author: "Cadu Barbosa"
excerpt: "Briefing 26/12: Zero-days ativos, falhas de patch e a mão pesada da regulamentação dominam a semana."
---

## 🛡️ Destaques da Semana

### Zero-Day Crítico em Oracle E-Business Expõe University of Phoenix
`ZERO-DAY, DATA BREACH, ORACLE`

- **O Fato:** Vazamento de dados de mais de 3.5 milhões de indivíduos na University of Phoenix via exploração de um zero-day no Oracle E-Business Suite, divulgado entre 23 e 25 de dezembro.
- **O Ruído:** O número exato de alunos afetados ou o impacto emocional da exposição de dados pessoais em massa.
- **O Sinal:** Exploração ativa de vulnerabilidade crítica em ERP amplamente utilizado, indicando falhas graves na gestão de patches e segurança de aplicações. O vetor é um software de missão crítica.
- **🔴 Ação:** Patcheie imediatamente sistemas Oracle E-Business Suite. Inicie varreduras de vulnerabilidade e testes de penetração em ambientes Oracle críticos. Revise logs para atividades anômalas.

### Grupo Clop Atribuído a Ataque Zero-Day na University of Phoenix
`RANSOMWARE, CLOP, ATTRIBUTION`

- **O Fato:** O grupo de ransomware Clop foi apontado como responsável pelo ataque e vazamento de dados na University of Phoenix, utilizando a exploração do zero-day no Oracle E-Business Suite.
- **O Ruído:** Especulações sobre a origem geográfica do grupo Clop ou detalhes sobre suas táticas de negociação.
- **O Sinal:** Confirmação da capacidade do Clop de explorar zero-days e escalar ataques, visando grandes organizações com dados sensíveis. Ameaça persistente e sofisticada.
- **🔴 Ação:** Revise e reforce suas defesas contra ransomware. Bloqueie IoCs associados ao Clop e audite controles de acesso para sistemas críticos. Treine equipes para detecção de anomalias.

### Falha Crítica em SonicWall Expõe 400K Clientes Bancários
`VULNERABILITY, DATA BREACH, FINTECH`

- **O Fato:** Em 20 de dezembro, foi noticiado um vazamento de dados que impactou 400.000 clientes bancários da fintech Marquis, resultado da exploração de uma vulnerabilidade conhecida em um firewall SonicWall sem correção.
- **O Ruído:** O drama da exposição dos dados pessoais ou a culpa na empresa fintech por não ter corrigido a falha.
- **O Sinal:** Falha básica na gestão de patches de infraestrutura crítica (firewall), resultando em acesso a dados financeiros sensíveis. Risco direto de compliance e reputação.
- **🔴 Ação:** Audite sua gestão de patches para firewalls e dispositivos de borda. Priorize CVEs conhecidas e aplique correções imediatamente. Isole sistemas vulneráveis até a remediação.

### FTC Pressiona Illusory Systems Por Falhas em Segurança Pós-Vazamento de US$186M
`REGULATORY, DATA BREACH, CRYPTO`

- **O Fato:** Em 23 de dezembro, a FTC anunciou ação fiscalizatória contra a Illusory Systems Inc. (Nomad) devido a um grande vazamento de dados onde hackers roubaram US$186 milhões de consumidores por falha em medidas de segurança.
- **O Ruído:** O valor astronômico roubado ou o foco excessivo na natureza das criptomoedas envolvidas.
- **O Sinal:** Consequências regulatórias severas para empresas que falham em implementar controles de segurança básicos e adequados, especialmente após incidentes. Precedente para futuras ações.
- **🔴 Ação:** Revise e fortaleça suas políticas de segurança de dados e planos de resposta a incidentes. Garanta conformidade regulatória proativa e invista em segurança como prioridade de negócio.

### CISA Atualiza Alerta Sobre Backdoor BRICKSTORM
`MALWARE, THREAT INTEL, CISA`

- **O Fato:** A CISA e parceiros divulgaram uma atualização para o Relatório de Análise de Malware BRICKSTORM Backdoor em 19 de dezembro de 2025.
- **O Ruído:** Detalhes excessivos sobre a complexidade técnica do malware ou a origem da ameaça sem foco na ação.
- **O Sinal:** Indicação de atividade persistente e evolução de uma ameaça conhecida, exigindo atenção contínua e atualização das defesas. O BRICKSTORM continua sendo um perigo.
- **🔴 Ação:** Revise IoCs e TTPs do BRICKSTORM. Garanta que suas defesas endpoint e de rede (EDR/NDR) estejam atualizadas para detectar e bloquear esta ameaça. Considere caça a ameaças proativa.

---

## 📜 Contexto Histórico

**1791 // Nascimento de Charles Babbage: O Pai da Computação**
Em 26 de dezembro de 1791, nasceu Charles Babbage, matemático e inventor inglês, reconhecido por suas ideias para o 'Difference Engine' e o 'Analytical Engine', que lançaram as bases para a computação moderna.

> 💡 *Lição: A inovação tecnológica sempre precede a necessidade de segurança. O legado de Babbage nos lembra que a base da computação moderna, embora revolucionária, não nasceu com a segurança em mente. Devemos sempre construir segurança desde o design.*

**2011 // Vazamento de E-mails da Stratfor por Anonymous**
Em 26 de dezembro de 2011, o grupo de hackers Anonymous reivindicou o roubo de milhares de endereços de e-mail e informações de cartão de crédito da empresa de segurança Stratfor, em um incidente amplamente divulgado.

> 💡 *Lição: Mesmo empresas de segurança são alvos. Este incidente reforça a necessidade de segurança em profundidade, que não há imunidade a ataques direcionados e que o fator humano/credenciais é sempre um vetor crítico.*

---

> "O único sistema verdadeiramente seguro é um que está desligado, fundido em um bloco de concreto e selado em uma sala revestida de chumbo com guardas armados - e mesmo assim, tenho minhas dúvidas."
>
> — **Bruce Schneier**