# GotiHub-AGL: Agentic Governance Ledger

[![Laravel 13](https://img.shields.io/badge/Laravel-13-FF2D20?logo=laravel\&logoColor=white)](https://laravel.com)
[![Gemma 4](https://img.shields.io/badge/AI-Gemma_4-blue?logo=google\&logoColor=white)](https://ai.google.dev/gemma)
[![Midnight Network](https://img.shields.io/badge/Privacy-Midnight_ZK--Proof-indigo)](https://midnight.network)

**GotiHub-AGL** is a governance-first local AI workflow platform designed for institutions that manage sensitive identity, approval, and transparency workflows.

Built with **Laravel 13**, **Gemma 4**, and the **Midnight Network**, the platform combines:

* Local AI reasoning
* Human governance workflows
* Zero-Knowledge privacy verification
* Institutional audit trails

Designed for:

* Schools & Universities
* NGOs & Donation Programs
* Enterprise approval systems
* High-trust organizations where data sovereignty matters

---

# Why We Built This

Many institutions still rely on manual workflows for:

* Alumni verification
* Donation transparency
* Identity validation
* Internal approvals
* Compliance review

Traditional AI systems often require sending confidential records to external cloud providers, creating major privacy and governance concerns.

GotiHub-AGL solves this problem by keeping reasoning local while generating cryptographic governance proofs for sensitive workflows.

---

# Live Demo

## Demo URL

```text id="ytn0o2"
http://152.42.168.170:8080
```

## Demo Access

```text id="w1c3go"
Email: apurbansinghdev@gmail.com
Password: Mid@Night@day@026
```

---

# Example Workflow

1. Secretary submits alumni verification request.
2. Gemma 4 reviews the request locally via Ollama.
3. AI generates:

   * reasoning trace
   * confidence score
   * governance risk assessment
4. High-risk requests trigger manager escalation.
5. Midnight Bridge generates a Zero-Knowledge proof without exposing sensitive institutional data.

---

# Why Gemma 4?

Institutional data should not leave institutional boundaries.

GotiHub-AGL uses **Gemma 4** locally to perform governance reasoning directly on trusted infrastructure.

## Key Advantages

### Local AI Reasoning

Sensitive records remain inside the organization.

### Governance-Aware Auditing

AI evaluates suspicious IDs, mismatched records, duplicate submissions, and policy violations.

### Operational Efficiency

Gemma 4 E4B provides lightweight local reasoning suitable for institutional deployments and low-cost infrastructure.

---

# Why Midnight Network?

AI reasoning alone is not enough for high-trust systems.

Institutions also need:

* verifiable approvals
* immutable audit trails
* privacy-preserving transparency
* donation accountability
* cryptographic compliance records

The **Midnight Bridge** generates Zero-Knowledge governance proofs after approval workflows complete.

This allows institutions to:

* prove workflow integrity
* validate approvals
* maintain auditability
* demonstrate financial transparency

without exposing sensitive personal or institutional data.

---

# System Architecture

The platform operates on a dual-governance model.

## 1. AI Governance Layer

Powered by [`laravel-agl`](https://github.com/apurba-labs/laravel-agl)

Features:

* Local Gemma reasoning
* Risk scoring
* Policy enforcement
* Human escalation workflows
* Governance decision tracing

---

## 2. Privacy Governance Layer

Powered by [`gotihub-midnight-bridge`](https://github.com/apurba-labs/gotihub-midnight-bridge)

Features:

* Zero-Knowledge proof generation
* Cryptographic governance sealing
* Privacy-preserving verification
* Immutable workflow evidence

---

# Core Repositories

| Repository                                                                          | Purpose                                              |
| ----------------------------------------------------------------------------------- | ---------------------------------------------------- |
| [`gotihub-agl`](https://github.com/apurba-labs/gotihub-agl)                         | Main governance platform and Filament control center |
| [`laravel-agl`](https://github.com/apurba-labs/laravel-agl)                         | Reusable Laravel package for AI governance workflows |
| [`gotihub-midnight-bridge`](https://github.com/apurba-labs/gotihub-midnight-bridge) | Midnight ZK-proof bridge powered by Bun              |

---

# Technical Stack

* Laravel 13
* Filament v5
* Gemma 4 via Ollama
* Midnight Network
* Bun Runtime
* Docker
* MySQL

---

# Local Development

## Prerequisites

* Docker & Docker Compose
* Ollama
* Bun Runtime

---

## Installation

```bash
git clone https://github.com/apurba-labs/gotihub-agl.git

cd gotihub-agl

cp .env.example .env

composer install
npm install

php artisan key:generate
```

---

## Pull Gemma 4

```bash
ollama pull gemma4:e4b
```

---

## Start Services

```bash
docker-compose up -d
```

---

# Roadmap

* [x] Local Gemma 4 governance workflows
* [x] Midnight ZK-proof integration
* [x] Human approval escalation system
* [ ] OCR support for legacy institutional documents
* [ ] Cross-institution governance federation
* [ ] Donation transparency governance layer
* [ ] Multi-tenant institutional deployment support

---

# Vision

GotiHub-AGL explores how local AI reasoning and Zero-Knowledge governance can modernize sensitive institutional workflows without sacrificing privacy, transparency, or human oversight.

---

Built by **Apurba Singh** at **ApurbaLabs** for the **Midnight Hackathon 2026**.

> “AI can recommend. Governance decides.”

---

# License

MIT License
