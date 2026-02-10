---
title: "Alerta 0-Day: MongoBleed, React2Shell e MSHTML Sob Ataque"
category: "Cyber"
image: "images/2026-02-10--rdc-cyber-020936.png"
date: "04 jan 2026"
author: "Cadu Barbosa"
excerpt: "Briefing 04/01: 0-Days críticos explorados, ransomware ativo e phishing via plataformas legítimas. Priorize patches e defesas."
---

## 🛡️ Destaques da Semana

### MongoBleed: 0-Day em MongoDB Explorado Ativamente
`0-DAY, VULNERABILITY`

- **O Fato:** Vulnerabilidade de vazamento de informação não autenticada (CVE-2025-14847) no MongoDB Server, apelidada de MongoBleed, está sendo ativamente explorada. Afeta o protocolo de compressão Zlib, permitindo leitura de memória heap não inicializada.
- **O Ruído:** O pânico sobre a complexidade do Zlib ou a 'facilidade' da exploração, desviando do impacto real.
- **O Sinal:** Exposição de dados sensíveis e credenciais devido à leitura de memória em instâncias MongoDB vulneráveis. O vetor é a falha no protocolo de compressão, exigindo atenção imediata.
- **🔴 Ação:** Patcheie imediatamente todas as instâncias MongoDB para a versão corrigida. Monitore logs de acesso e tráfego de rede para anomalias.

### React2Shell: RCE Crítica em React/Next.js Alimenta Botnet
`RCE, IoT, WEB APP`

- **O Fato:** Vulnerabilidade crítica React2Shell (CVE-2025-55182) em React Server Components (RSC) e Next.js permite execução remota de código (RCE) não autenticada. A botnet RondoDox a explora para sequestrar dispositivos IoT e servidores web.
- **O Ruído:** O alarde sobre a 'queda da internet' ou a complexidade do React, sem focar na ação defensiva necessária.
- **O Sinal:** Ameaça direta a infraestruturas web e IoT. Exploração em massa para expansão de botnets, com mais de 90 mil instâncias ainda vulneráveis, representando um risco sistêmico.
- **🔴 Ação:** Atualize React Server Components e Next.js para as versões corrigidas. Isole e audite dispositivos IoT expostos à internet.

### MSHTML: 0-Day RCE no Windows Ataca Governos e Finanças
`0-DAY, RCE, SPEAR-PHISHING`

- **O Fato:** Vulnerabilidade crítica de execução remota de código (RCE) no motor Windows MSHTML (CVE-2025-36918) está sendo ativamente explorada. Campanhas de spear-phishing de alta precisão visam instituições governamentais e financeiras.
- **O Ruído:** O foco na 'sofisticação' dos atacantes ou o 'quão fácil' é cair em phishing, em vez de medidas proativas.
- **O Sinal:** Risco elevado de comprometimento de endpoints e redes corporativas através de e-mails maliciosos. A exploração é direcionada e eficaz, exigindo defesa em camadas.
- **🔴 Ação:** Aplique a atualização de segurança de emergência da Microsoft para MSHTML. Reforce treinamentos de conscientização contra spear-phishing e implemente defesas de e-mail robustas.

### Atos Sob Ataque: Ransomware 'Space Bears' Reivindica Invasão
`RANSOMWARE, DATA BREACH`

- **O Fato:** O grupo de ransomware 'Space Bears' reivindicou uma invasão à Atos em 28 de dezembro de 2025, ameaçando publicar dados roubados até 8 de janeiro. A Atos está investigando, sem evidências de comprometimento em seus sistemas até o momento.
- **O Ruído:** Especulações sobre a veracidade da alegação ou o impacto financeiro na Atos, sem foco na inteligência acionável.
- **O Sinal:** Confirmação de que grupos de ransomware continuam ativos e visam grandes corporações. A ameaça de exposição de dados é iminente, mesmo com negação inicial.
- **🔴 Ação:** Monitore ativamente a dark web para dados da Atos e de parceiros. Revise e teste planos de resposta a incidentes de ransomware e exfiltração de dados.

### Google Tasks Explorado em Campanha de Phishing Global
`PHISHING, SOCIAL ENGINEERING`

- **O Fato:** Campanha de phishing sofisticada explorou notificações do Google Tasks para atingir mais de 3.000 organizações globalmente durante dezembro de 2025.
- **O Ruído:** O foco na 'ingenuidade' das vítimas ou a 'falha' do Google, em vez de estratégias de defesa.
- **O Sinal:** Ameaça persistente de phishing que abusa de plataformas legítimas e confiáveis. Engenharia social avançada para bypass de controles de e-mail tradicionais.
- **🔴 Ação:** Eduque usuários sobre phishing via plataformas legítimas e notificações. Implemente MFA e revise políticas de segurança para aplicativos de produtividade e colaboração.

---

## 📜 Contexto Histórico

**1972 // HP-35: A Calculadora que Mudou Tudo**
Em 4 de janeiro de 1972, a Hewlett-Packard introduziu a HP-35, a primeira calculadora científica portátil, revolucionando a computação pessoal e profissional.

> 💡 *Lição: A inovação tecnológica sempre traz consigo novas superfícies de ataque e desafios de segurança. O controle de ativos e a gestão de dispositivos são perenes.*

**2001 // Linux 2.4: Um Salto para o Open Source**
Em 4 de janeiro de 2001, Linus Torvalds lançou a versão 2.4 do código-fonte do kernel Linux, um marco significativo no desenvolvimento do sistema operacional de código aberto.

> 💡 *Lição: A segurança de sistemas operacionais e componentes de código aberto é fundamental. Vulnerabilidades em kernels podem ter impacto sistêmico e exigir atenção contínua.*

---

> "Segurança é um processo, não um produto."
>
> — **Bruce Schneier**