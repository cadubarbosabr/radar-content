---
title: "Para cada identidade humana no seu Directory, existem 50 identidades de máquina invisíveis operando com privilégio máximo. O vetor de ataque mudou."
category: "Strategy"
image: images/rdc-IAM-2025-12-26.png
date: "26 Dez 2025"
author: "Cadu Barbosa"
excerpt: "O Zero Trust falha quando focamos apenas na biometria do usuário e ignoramos a API Key hardcoded no código. A identidade da máquina é o novo ponto cego da resiliência cibernética."
---

# Para cada identidade humana no seu Directory, existem 50 identidades de máquina invisíveis operando com privilégio máximo. O vetor de ataque mudou.

- ⚠️ **A Crise das NHI (Non-Human Identities):** Service Accounts, Tokens OAuth e API Keys crescem exponencialmente. Elas não fazem logoff, não usam MFA e frequentemente carregam permissões de 'God Mode' estáticas.
- 🛡️ **Identity Security Fabric (ISF):** A abordagem de silos (IGA separado de PAM separado de AM) morreu. A nova arquitetura exige um plano de controle unificado que integre ITDR (Detection & Response) para cobrir a lacuna de visibilidade em ambientes híbridos e multi-cloud.
- 🔑 **De Secrets para Managed Identities:** A recomendação crítica do ecossistema (incluindo Microsoft Entra ID) é a eliminação agressiva de *long-lived secrets*. A migração para *Workload Identities* sujeitas a políticas de Acesso Condicional é o novo padrão de higiene.
- 🚨 **Vulnerabilidade e Escala:** Com falhas críticas recentes em validação de tokens (como a CVE-2025-55241 do Azure AD Graph), a falta de governança estrita sobre quem (ou o que) está autenticando pode comprometer tenants inteiros.

### 💡 Insight
O Zero Trust falha quando focamos apenas na biometria do usuário e ignoramos a API Key hardcoded no código. A identidade da máquina é o novo ponto cego da resiliência cibernética.

### 👇 Call to Action
Você possui inventário automatizado e rotação de credenciais para as Service Accounts críticas do seu ambiente, ou elas são 'contas de serviço' esquecidas?

#IAM #NonHumanIdentity #ZeroTrust #CyberSecurity #RadarDoCadu

![Visual IAM](../images/rdc-IAM-2025-12-26.png)
