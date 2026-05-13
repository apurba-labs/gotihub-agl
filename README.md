# GotiHub-AGL: Sovereign Alumni Verification Platform

[![Gemma 4 Challenge](https://img.shields.io/badge/Gemma_4-Challenge-blue?logo=google&logoColor=white)](https://dev.to/challenges/gemma)
[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Midnight Network](https://img.shields.io/badge/Privacy-Midnight_ZK--Proof-indigo)](https://midnight.network)

**GotiHub-AGL** (Agentic Governance Ledger) is a decentralized identity verification platform designed for 100-year-old institutions. It bridges the gap between legacy academic records and modern privacy-preserving technology using **Gemma 4** for local policy auditing and the **Midnight Network** for Zero-Knowledge (ZK) proofs.

---

## The Innovation: Why Gemma 4?

Institutional data is sensitive. Moving it to a public cloud for AI analysis is a compliance nightmare. **GotiHub-AGL** solves this by deploying **Gemma 4 E4B** locally on institutional hardware.

- **Local Reasoning:** Gemma 4 audits alumni verification requests against complex institutional policies without the data ever leaving the server.
- **Agentic Auditor:** Unlike static rules, the AI acts as a "Sovereign Auditor," providing detailed rationale (Markdown) for flagging or verifying high-risk records.
- **Privacy First:** By using a local 4B model, we maintain a small footprint (running on 8GB RAM) while achieving server-grade reasoning.

---

## Technical Stack

- **Core Engine:** Laravel 13 (PHP 8.3+) with Native Attributes.
- **AI Brain:** Gemma 4 (E4B / 31B) via Ollama.
- **ZK-Proving:** Midnight Network (Compact/TypeScript Bridge).
- **Frontend:** Filament v5 (Unified Schema) for high-fidelity dashboards.
- **Infrastructure:** Dockerized for local or cloud (DigitalOcean) deployment.

---

## Architecture

The platform operates on a "Dual-Governance" model:

1. **AI Governance:** The [`laravel-agl`](https://github.com/apurba-labs/laravel-agl) engine sends record data to **Gemma 4**. The AI evaluates risks (mismatched years, suspicious IDs) and generates a **Sovereign Auditor Rationale**.
2. **Cryptographic Governance:** Once the AI and Manager approve, a Zero-Knowledge Proof is generated via the **Midnight Bridge**. This seals the verification into an immutable proof without exposing personal data.

---

## Getting Started (Local Development)

### 1. Prerequisites
- Docker & Docker Compose
- Ollama (Running Gemma 4)
- Bun (For Midnight Sidecar)

### 2. Installation
```bash
# Clone the repository
git clone https://github.com/apurba-labs/gotihub-agl.git

cd gotihub-agl

# Install dependencies
composer install && npm install

# Set up environment
cp .env.example .env
php artisan key:generate

### 3. Load Gemma 4

ollama pull gemma4:4b

### 4. Start Services

docker-compose up -d

```

---

## Roadmap

- [x] Gemma 4 Agentic Integration

- [x] Midnight ZK-Proof Sealing

- [ ] Multimodal OCR for Legacy Paper Certificates (Coming Soon)

- [ ] Cross-Institution Verification Ledger

---

## 🤝 Collaboration & Mission

Built by **Apurba Singh** at **ApurbaLabs** for the **Midnight Network Hackathon**.

> "Securing Institutional Identity with Zero-Knowledge Governance."

---

## 📜 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.