---
title: "Alerta Crítico: Zero-Days Ativos e Ransomware Clop no Fim do Ano"
category: "Cyber"
image: "images/2026-02-10--rdc-cyber-.png"
date: "26 dez 2025"
author: "Cadu Barbosa"
excerpt: "Briefing 26/12: Múltiplos 0-days em Oracle, MS, Cisco e WatchGuard exigem ação imediata. Clop explora Oracle EBS."
---

## 🛡️ Destaques da Semana

### Oracle EBS: 0-Day Crítico (CVE-2025-61882) Explorado Ativamente por Clop
`0-DAY, RANSOMWARE, ORACLE EBS, CLOP`

- **O Fato:** Uma RCE não autenticada no Oracle E-Business Suite BI Publisher (CVE-2025-61882) está sob exploração ativa, permitindo execução de código e associada a campanhas de ransomware. A Oracle liberou patch de emergência.
- **O Ruído:** O pânico sobre 'todos os sistemas Oracle estão comprometidos' ou a complexidade técnica da desserialização.
- **O Sinal:** O vetor é RCE não autenticada em um componente de integração exposto, usado para roubo de dados e ransomware por atores como Clop.
- **🔴 Ação:** Patcheie imediatamente todas as instâncias de Oracle E-Business Suite BI Publisher. Isole sistemas não patchados e monitore logs para atividades anômalas.

### Microsoft WSUS: RCE Crítica (CVE-2025-59287) sob Exploração Ativa
`0-DAY, MICROSOFT, WSUS, RCE`

- **O Fato:** Uma vulnerabilidade crítica de execução remota de código (CVE-2025-59287) foi descoberta e está sendo ativamente explorada nos Serviços de Atualização do Windows Server (WSUS).
- **O Ruído:** Detalhes excessivos sobre o mecanismo de desserialização ou especulações sobre os atacantes.
- **O Sinal:** A falha permite RCE via dados serializados manipulados, comprometendo servidores WSUS e, potencialmente, a cadeia de distribuição de patches.
- **🔴 Ação:** Patcheie todos os servidores WSUS urgentemente. Revise as configurações de segurança do WSUS e monitore o tráfego de rede para anomalias.

### SharePoint: 0-Day RCE (CVE-2025-53770) Ativamente Explorada
`0-DAY, MICROSOFT, SHAREPOINT, RCE`

- **O Fato:** Uma RCE não autenticada no Microsoft SharePoint (CVE-2025-53770), devido a desserialização insegura, está sob exploração ativa com payloads maliciosos.
- **O Ruído:** Pânico generalizado sobre 'SharePoint está quebrado' ou discussões sobre a origem do ataque.
- **O Sinal:** A exploração permite RCE em servidores SharePoint, um alvo rico em dados e acesso interno.
- **🔴 Ação:** Patcheie todos os servidores Microsoft SharePoint imediatamente. Implemente regras de firewall para restringir acesso a endpoints vulneráveis e monitore logs de acesso.

### WatchGuard Firebox: 0-Day Crítico (CVE-2025-14733) em Exploração
`0-DAY, FIREWALL, WATCHGUARD, RCE, CISA KEV`

- **O Fato:** Uma vulnerabilidade zero-day crítica (CVSS: 9.3) em firewalls WatchGuard Firebox (CVE-2025-14733) está sendo ativamente explorada para RCE sem autenticação. CISA adicionou ao KEV.
- **O Ruído:** Discussões sobre a marca WatchGuard ou o impacto em pequenas empresas.
- **O Sinal:** RCE não autenticada em um dispositivo de borda de rede, permitindo controle total do firewall e acesso à rede interna.
- **🔴 Ação:** Patcheie todos os firewalls WatchGuard Firebox imediatamente. Revise as configurações e logs de acesso dos firewalls para sinais de comprometimento.

### Cisco AsyncOS: 0-Day (CVE-2025-20393) Explorada por APT Chinês
`0-DAY, CISCO, APT, ASYNC OS, RCE`

- **O Fato:** Cisco alertou sobre exploração ativa de um zero-day de máxima gravidade (CVE-2025-20393) no software AsyncOS por um grupo APT ligado à China (UAT-9686), permitindo RCE com privilégios de root.
- **O Ruído:** Especulações geopolíticas sobre o grupo APT ou a complexidade do ataque.
- **O Sinal:** RCE com privilégios de root em dispositivos de segurança de e-mail Cisco, um ponto crítico para interceptação e persistência.
- **🔴 Ação:** Patcheie todos os dispositivos Cisco AsyncOS afetados. Monitore logs para atividades suspeitas e IoCs relacionados ao UAT-9686.

### Citrix NetScaler: 0-Day RCE (CVE-2025-7775) Ativamente Explorada
`0-DAY, CITRIX, NETSCALER, RCE`

- **O Fato:** Uma vulnerabilidade de execução remota de código não autenticada (CVE-2025-7775) em appliances NetScaler ADC e NetScaler Gateway da Citrix está sob exploração ativa, com webshells observados.
- **O Ruído:** O histórico de vulnerabilidades da Citrix ou o número de organizações afetadas.
- **O Sinal:** RCE não autenticada em dispositivos de acesso remoto e balanceamento de carga, abrindo a porta para acesso inicial e persistência.
- **🔴 Ação:** Patcheie todos os appliances Citrix NetScaler ADC e Gateway. Procure por webshells e IoCs em dispositivos comprometidos.

### Redis: Nova 0-Day RCE (CVE-2025-49844) Expõe Milhões de Implantações
`0-DAY, REDIS, RCE, DATASTORE`

- **O Fato:** Uma vulnerabilidade zero-day recém-divulgada no Redis (CVE-2025-49844) permite RCE via um bug de use-after-free no mecanismo de script Lua, expondo milhões de implantações.
- **O Ruído:** Pânico sobre 'todos os bancos de dados estão em risco' ou a complexidade do bug de use-after-free.
- **O Sinal:** Usuários autenticados podem escapar do sandbox Lua e executar comandos arbitrários no host, comprometendo o datastore e a infraestrutura subjacente.
- **🔴 Ação:** Aplique o patch de emergência do Redis. Restrinja o acesso ao Redis e revise as configurações de segurança, especialmente para ambientes com usuários autenticados.

---

## 📜 Contexto Histórico

**1831 // Charles Babbage e o Conceito do Computador**
Em 26 de dezembro de 1831, Charles Babbage detalhou o projeto para sua 'Máquina Analítica', um conceito considerado um precursor do computador moderno.

> 💡 *Lição: A base da computação moderna foi lançada com a visão de Babbage, destacando a importância da arquitetura e lógica para processamento de dados.*

**1991 // Timothy Berners-Lee Publica o Primeiro Site**
Em 26 de dezembro de 1991, Timothy Berners-Lee colocou o primeiro site online (info.cern.ch), tornando a informação acessível a todos e lançando as bases para a internet como a conhecemos.

> 💡 *Lição: A democratização da informação trouxe avanços sem precedentes, mas também complexidade e novos vetores de ataque que hoje gerenciamos.*

---

> "Se você gastar mais dinheiro em paredes do que em portas, você terá um sistema muito seguro e muito inutilizável."
>
> — **Bruce Schneier**
