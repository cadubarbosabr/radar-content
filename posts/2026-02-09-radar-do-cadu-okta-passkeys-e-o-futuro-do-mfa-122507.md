---
title: "Radar do Cadu: Okta, Passkeys e o Futuro do MFA"
category: "IAM"
image: "images/2026-02-10-rdc-cyber-2026-02-09-122507.png"
date: "09 fev 2026"
author: "Cadu Barbosa"
excerpt: "Atualizações críticas no Okta Identity Engine, a ascensão dos Passkeys e a urgência de MFA phishing-resistant."
---

## 🆔 Destaques da Identidade (IAM)

### Okta Identity Engine: Criptografia OIDC e APIs 'Anything-as-a-Source'
`OKTA, OIDC, CIAM`

- **O Fato:** O Okta Identity Engine lançou atualizações (v2026.01.2 Prod, v2026.02.0 Preview) incluindo criptografia para tokens OIDC ID e de acesso, geração unificada de claims (GA), e 'Anything-as-a-Source APIs' para gerenciar usuários e grupos no Universal Directory.
- **O Ruído:** Detalhes específicos das versões (2026.01.2, 2026.02.0) e a menção de 'Geralmente Disponível em Produção' para claims unificados.
- **O Sinal:** Maior segurança para tokens OIDC, simplificação da gestão de claims personalizados e flexibilidade expandida para integração de fontes de identidade, impactando diretamente a segurança e a governança de CIAM e IGA.
- **🔑 Ação IAM:** Avalie a necessidade de criptografia de tokens OIDC, revise as configurações de claims e explore as novas APIs para sincronização de diretórios e fontes de identidade.

### Okta Classic Engine: Gerenciamento Bidirecional de Grupos LDAP
`OKTA, IGA, LDAP`

- **O Fato:** A versão mensal 2026.02 do Okta Classic Engine expandiu a API de Gerenciamento de Grupo Bidirecional, permitindo a gestão direta de grupos LDAP a partir do Okta, incluindo adição e remoção de usuários.
- **O Ruído:** Apenas a referência à 'versão mensal 2026.02' sem detalhes adicionais.
- **O Sinal:** Melhora significativa na governança e sincronização de grupos em ambientes híbridos, reduzindo a complexidade e inconsistências na gestão de acessos baseada em grupos.
- **🔑 Ação IAM:** Mapeie grupos LDAP críticos, planeje a integração bidirecional e audite as permissões de gerenciamento para garantir o controle de acesso.

### Adoção Massiva de Passkeys: 4 Bilhões em Uso Globalmente
`PASSKEYS, FIDO2, ZERO TRUST`

- **O Fato:** Andrew Shikiar, CEO da FIDO Alliance, estimou que mais de 4 bilhões de passkeys estão sendo usadas globalmente para proteger acessos, consolidando 2025 como um ano chave para a adoção em massa.
- **O Ruído:** A menção de '2025 como um ano crucial' é uma retrospectiva, o foco é o status atual da adoção.
- **O Sinal:** Confirma a aceleração da adoção de autenticação phishing-resistant baseada em padrões FIDO, reforçando a estratégia de eliminação de senhas e os pilares de Zero Trust.
- **🔑 Ação IAM:** Priorize o roadmap de implementação de Passkeys, eduque usuários e valide a compatibilidade de IdPs e aplicações com este método de autenticação.

### MFA Tradicional Insuficiente: A Urgência do MFA Adaptativo
`MFA, ZERO TRUST, PHISHING-RESISTANT`

- **O Fato:** Uma análise de 9 de fevereiro de 2026 indicou que métodos tradicionais de MFA não são mais suficientes contra ataques avançados, automatizados e baseados em engenharia social, exigindo MFA mais inteligente e resistente a phishing.
- **O Ruído:** A natureza da 'análise publicada' e a 'discussão aponta' são detalhes secundários.
- **O Sinal:** A necessidade urgente de migrar de MFA básico para soluções adaptativas e phishing-resistant (e.g., FIDO2/Passkeys) para fortalecer a postura de segurança e a conformidade com Zero Trust.
- **🔑 Ação IAM:** Avalie a resiliência do seu MFA atual, invista em soluções phishing-resistant e implemente políticas de acesso condicional adaptativas para mitigar riscos.

---

## 📜 Contexto Histórico

**2026 // Quebra de Criptografia de Celular pela PF**
Em 9 de fevereiro de 2026, a Polícia Federal conseguiu quebrar a criptografia do celular de Daniel Vorcaro, proprietário do Banco Master, acessando dados cruciais para a investigação.

> 💡 *Lição: A resiliência da criptografia é um alvo constante. A segurança de dados em repouso e em trânsito exige camadas robustas, e a gestão de chaves é tão crítica quanto a autenticação para a proteção da identidade e dos dados.*

---

> "A privacidade não conhece fronteiras: temos que proteger a privacidade globalmente ou não a protegemos em lugar nenhum!"
>
> — **Ann Cavoukian**