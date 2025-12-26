---
title: "CVSS 10.0 no Entra ID: O isolamento de tenants falhou silenciosamente. A confiança implícita no IdP é o novo vetor de risco crítico. ⚠️"
category: "Strategy"
image: "images/rdc-briefing-2025-12-26.png"
date: "26 Dez 2025"
author: "Cadu Barbosa"
excerpt: "Zero Trust aplica-se também ao seu provedor de identidade. Centralizar a autenticação sem uma camada independente de ITDR (Identity Threat Detection and Response) cria um ponto único de falha catastrófico. Assumir violação significa monitorar anomalias até mesmo nos logs do seu IdP."
---

# CVSS 10.0 no Entra ID: O isolamento de tenants falhou silenciosamente. A confiança implícita no IdP é o novo vetor de risco crítico. ⚠️

- A vulnerabilidade (CVE-2025-55241) na API Azure AD Graph permitiu bypass de validação de tokens, viabilizando acesso cross-tenant não autorizado.
- O cenário de ataque permitia a impersonação de qualquer usuário, incluindo Global Admins, concedendo controle total sobre serviços como SharePoint e Exchange Online.
- Embora a Microsoft tenha mitigado a falha em 17 de julho de 2025, o incidente expõe a fragilidade da validação de 'actor tokens' em arquiteturas multi-tenant complexas.

### 💡 Insight
Zero Trust aplica-se também ao seu provedor de identidade. Centralizar a autenticação sem uma camada independente de ITDR (Identity Threat Detection and Response) cria um ponto único de falha catastrófico. Assumir violação significa monitorar anomalias até mesmo nos logs do seu IdP.

### 👇 Call to Action
Se o seu Identity Provider fosse comprometido hoje, sua estratégia de monitoramento detectaria a movimentação lateral ou você confia cegamente na caixa preta?

#RadarDoCadu #EntraID #ITDR #IdentitySecurity #ZeroTrust

![Visual IAM](../images/rdc-briefing-2025-12-26.png)
