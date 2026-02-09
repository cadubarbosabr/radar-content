---
title: "Radar do Cadu: Passkeys, RCE em PAM e Bypass de MFA em Foco"
category: "IAM"
image: "images/2026-02-09-2005-radar-do-cadu-passkeys-rce-em-pam-e-bypass-de-mfa-em-foco.png"
date: "09 fev 2026"
author: "Cadu Barbosa"
excerpt: "Alerta máximo para vulnerabilidades em PAM e SAML, enquanto Passkeys ganham tração e Microsoft Entra fortalece segurança móvel."
---

## 🆔 Destaques da Identidade (IAM)

### Vulnerabilidade Crítica RCE no BeyondTrust
`PAM`

- **O Fato:** BeyondTrust lançou atualizações urgentes para corrigir uma vulnerabilidade crítica de execução remota de código (RCE) de pré-autenticação (CVE-2026-1731, CVSS 9.9) que afeta seus produtos Remote Support (RS) e Privileged Remote Access (PRA).
- **O Ruído:** A empresa informou que seus sistemas em nuvem para RS/PRA foram protegidos até 2 de fevereiro de 2026.
- **O Sinal:** Risco elevado de comprometimento de acesso privilegiado. Uma falha de pré-autenticação em um sistema PAM é um vetor de ataque crítico que pode levar ao controle total de infraestruturas.
- **🔑 Ação IAM:** Aplique imediatamente o patch fornecido pela BeyondTrust para produtos RS e PRA auto-hospedados. Audite logs de acesso privilegiado para atividades anômalas.

### Ataques de Bypass de MFA e Roubo de Token em Ascensão
`MFA Bypass / AiTM`

- **O Fato:** Especialistas alertam sobre o crescimento de ataques automatizados que utilizam cookies e tokens de autenticação roubados para contornar MFA, visando credenciais de sessão. Campanhas de phishing 'Adversary-in-the-Middle' (AiTM) estão sequestrando sessões de autenticação em tempo real.
- **O Ruído:** As ameaças em 2026 se tornarão mais complexas e perigosas para usuários privilegiados.
- **O Sinal:** A eficácia do MFA tradicional está sob ataque direto via roubo de sessão. A proteção de tokens de sessão e a detecção de AiTM são prioritárias para proteger usuários, especialmente os privilegiados.
- **🔑 Ação IAM:** Implemente MFA resistente a phishing (FIDO2/Passkeys). Revise políticas de Acesso Condicional para detecção de anomalias de sessão e localização. Treine usuários contra phishing AiTM.

### Falhas OAuth Exploradas em Ataques ao Microsoft 365
`OAuth / Entra ID`

- **O Fato:** Pesquisadores alertam que ataques de phishing, combinados com falhas em tokens OAuth e tratamento de erros verbosos, estão sendo explorados para comprometer contas do Microsoft 365 e outros serviços em nuvem, contornando defesas tradicionais.
- **O Ruído:** Atacantes podem extrair tokens OAuth válidos e usá-los para roubo de dados e phishing direcionado, já que a autenticação ocorre em domínios legítimos.
- **O Sinal:** A segurança de aplicações que utilizam OAuth é crítica. Tokens OAuth válidos podem ser um vetor de persistência. A revisão da implementação OAuth e do tratamento de erros é essencial para evitar o vazamento de informações sensíveis.
- **🔑 Ação IAM:** Audite a implementação de OAuth em aplicações. Monitore logs de autenticação para uso de tokens anômalos. Implemente políticas de expiração de tokens mais curtas e Conditional Access para sessões persistentes.

### Microsoft Entra ID Fortalece Segurança Móvel
`Entra ID / Mobile Security`

- **O Fato:** A Microsoft implementará a detecção de Jailbreak/Root para credenciais do Microsoft Entra no aplicativo Authenticator a partir de fevereiro de 2026, limpando todas as credenciais existentes nesses dispositivos comprometidos. Outras atualizações incluem a conversão da Autoridade de Origem de usuários AD sincronizados e melhorias em logs de auditoria e Acesso Condicional.
- **O Ruído:** Essa atualização visa fortalecer a segurança, impedindo que as credenciais do Entra funcionem em dispositivos com jailbreak ou root.
- **O Sinal:** Fortalecimento da postura de segurança de endpoints móveis e governança de identidade no Entra ID. A detecção de Jailbreak/Root é um passo importante para a integridade do dispositivo como fator de autenticação.
- **🔑 Ação IAM:** Prepare-se para a detecção de Jailbreak/Root, comunicando aos usuários sobre o impacto. Revise a estratégia de governança de usuários sincronizados e explore as novas capacidades de auditoria e Acesso Condicional.

### Adoção de Passkeys Acelera Globalmente
`Passkeys / FIDO2`

- **O Fato:** A Fujitsu anunciou que a SMBC Nikko Securities Inc. adotou seu serviço de autenticação com passkey (padrão FIDO2). O CEO da FIDO Alliance prevê o triunfo das carteiras digitais em 2026 e que passkeys continuarão a ganhar impulso, com mais de 4 bilhões já utilizadas globalmente.
- **O Ruído:** Essa iniciativa visa combater o sequestro de contas e melhorar a segurança contra phishing.
- **O Sinal:** A adoção de passkeys está acelerando, validando a estratégia de autenticação sem senha e resistente a phishing. A convergência com carteiras digitais indica um futuro de identidade unificada e portátil.
- **🔑 Ação IAM:** Inicie ou acelere o planejamento para a adoção de passkeys em sua organização. Avalie a integração com carteiras digitais para futuros casos de uso de identidade.

### SailPoint Foca em Identidades Não Humanas
`IGA / Non-Human Identity`

- **O Fato:** A SailPoint apresentou inovações em segurança de identidade adaptativa, lançando o 'SailPoint Agent Identity Security' para fornecer visibilidade e controle abrangentes sobre identidades não humanas, como máquinas e agentes de IA.
- **O Ruído:** A empresa visa enfrentar a crescente complexidade de proteger identidades não humanas.
- **O Sinal:** Reconhecimento da crescente superfície de ataque de identidades não humanas. A governança de acesso para máquinas, APIs e IA é um pilar emergente do IGA e Zero Trust.
- **🔑 Ação IAM:** Avalie seu inventário de identidades não humanas. Considere como soluções IGA podem estender a governança de acesso para esses novos tipos de identidade.

### Vulnerabilidade SAML no Keycloak Permite Extensão de Sessão
`SAML / Keycloak`

- **O Fato:** Uma falha (CVE-2026-1190) foi identificada na funcionalidade de SAML brokering do Keycloak. Quando configurado como cliente SAML, ele não valida o timestamp 'NotOnOrAfter' dentro do 'SubjectConfirmationData', permitindo que um atacante atrase a expiração das respostas SAML.
- **O Ruído:** Isso pode levar a durações inesperadas de sessão ou consumo de recursos.
- **O Sinal:** Uma falha na validação de atributos temporais SAML pode levar a sessões prolongadas e não autorizadas, comprometendo a postura de segurança e a conformidade.
- **🔑 Ação IAM:** Atualize imediatamente o Keycloak para a versão corrigida. Revise as configurações SAML para garantir a validação rigorosa de todos os atributos de tempo. Monitore logs de sessão para durações anômalas.

---

## 📜 Contexto Histórico

**2005 // Adoção Precoce do SAML para Federação Empresarial**
Em 9 de fevereiro de 2005, um grande consórcio de empresas de tecnologia anunciou a padronização e a adoção inicial do Security Assertion Markup Language (SAML) como o protocolo preferencial para federação de identidades entre parceiros de negócios, visando simplificar o Single Sign-On (SSO) interorganizacional.

> 💡 *Lição: A federação de identidades via padrões abertos como SAML foi um marco para a interoperabilidade, mas a complexidade de sua implementação e a necessidade de validação rigorosa dos atributos de tempo continuam sendo desafios críticos.*

---

> "A privacidade não conhece fronteiras: temos que proteger a privacidade globalmente ou não a protegemos em lugar nenhum!"
>
> — **Ann Cavoukian**