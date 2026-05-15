<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>GotiHub AGL | Governance-First AI Workflows</title>
    
    <!-- Vite Assets (Restored) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0f172a;
            color: #e2e8f0;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.5;
            overflow-x: hidden;
            width: 100%;
            font-size: 16px; /* Base font size */
        }

        /* Consistent typography scale */
        h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        
        h2 {
            font-size: clamp(1.5rem, 4vw, 2.25rem);
            font-weight: 700;
            letter-spacing: -0.01em;
        }
        
        h3 {
            font-size: 1.25rem;
            font-weight: 600;
        }
        
        .text-body {
            font-size: 1rem;
            line-height: 1.6;
        }
        
        .text-small {
            font-size: 0.875rem;
        }
        
        .text-tiny {
            font-size: 0.75rem;
        }

        .container-custom {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
            width: 100%;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #38bdf8 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .workflow-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .scenarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .workflow-grid, .scenarios-grid, .features-grid {
                grid-template-columns: 1fr;
            }
            .container-custom {
                padding: 0 1rem;
            }
            h3 {
                font-size: 1.125rem;
            }
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: linear-gradient(95deg, #f59e0b, #ea580c);
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            color: #000;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px -6px rgba(245, 158, 11, 0.3);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: transparent;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.75rem;
            font-weight: 500;
        }

        .risk-bar {
            background: #1e293b;
            border-radius: 9999px;
            height: 4px;
            overflow: hidden;
            flex: 1;
        }

        .risk-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.3s;
        }
        
        .step-number {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.75rem auto;
            font-size: 1.125rem;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <!-- ===== NAVBAR ===== -->
    <nav style="position: sticky; top: 0; z-index: 50; width: 100%; border-bottom: 1px solid rgba(51, 65, 85, 0.5); background: rgba(2, 6, 23, 0.9); backdrop-filter: blur(16px);">
        <div class="container-custom" style="display: flex; align-items: center; justify-content: space-between; padding-top: 0.875rem; padding-bottom: 0.875rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <!-- Your Logo Image -->
                <img src="/logo.jpeg" alt="GotiHub Logo" style="width: 2rem; height: 2rem; border-radius: 0.5rem; object-fit: cover;">
                <h1 style="font-size: 1.25rem; font-weight: 800;">GotiHub <span style="color: #fbbf24;">AGL</span></h1>
            </div>
            
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <a href="https://github.com/apurba-labs/gotihub-agl" target="_blank" style="color: #cbd5e1; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s;" onmouseover="this.style.color='white'" onmouseout="this.style.color='#cbd5e1'">GitHub</a>
                    <a href="http://152.42.168.170:8080/admin/login" style="padding: 0.5rem 1rem; border-radius: 9999px; background: #f59e0b; color: #000; font-weight: 600; font-size: 0.75rem; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='#fbbf24'" onmouseout="this.style.background='#f59e0b'">Live Demo →</a>
                </div>
                <!-- Midnight Hackathon Badge -->
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="display: inline-flex; align-items: center; gap: 0.375rem; padding: 0.25rem 0.75rem; background: linear-gradient(135deg, rgba(56, 189, 248, 0.15), rgba(245, 158, 11, 0.15)); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 9999px; font-size: 0.65rem; font-weight: 500; color: #7dd3fc;">
                        🌙 Built for Midnight Hackathon 2026
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <!-- ===== HERO SECTION ===== -->
    <section style="position: relative; padding: 4rem 0 3rem 0; overflow-x: hidden;">
        <div style="position: absolute; inset: 0; background: radial-gradient(ellipse at top right, rgba(56, 189, 248, 0.08), transparent 70%); pointer-events: none;"></div>
        <div class="container-custom" style="position: relative;">
            <div style="max-width: 48rem;">
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <span class="badge">⚡ Local-first AI</span>
                    <span class="badge">🔐 Zero-Knowledge proofs</span>
                    <span class="badge">🏛 Governance layer</span>
                </div>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-slate-700 bg-slate-900/80 text-sm text-slate-300 mb-8">
                    Powered by Laravel 13 • Gemma 4 • Midnight Network
                </div>
                <h1 style="margin-bottom: 1rem;">
                    Where <span class="gradient-text">Governance</span><br>
                    Meets Intelligent <span class="gradient-text">Workflows</span>
                </h1>
                <p style="font-size: 1rem; color: #cbd5e1; max-width: 42rem; margin-bottom: 1.5rem; line-height: 1.6;">
                    GotiHub AGL helps institutions secure sensitive approval and verification workflows using local AI reasoning, human governance escalation, and Zero-Knowledge audit verification.
                </p>
                <div style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <a href="http://152.42.168.170:8080/admin/login" class="btn-primary">Launch Governance Hub →</a>
                    <a href="https://github.com/apurba-labs/gotihub-agl" class="btn-secondary">Explore on GitHub</a>
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 1rem; font-size: 0.75rem; color: #64748b;">
                    <span>🔒 Zero-trust ready</span>
                    <span>🤖 Gemma 4 (Ollama)</span>
                    <span>📜 Verifiable audit trail</span>
                </div>
            </div>
        </div>
    </section>

<!-- ===== WORKFLOW SECTION - HORIZONTAL FLOW ===== -->
<!-- ===== WORKFLOW SECTION - KILLER VERSION ===== -->
<section style="padding: 5rem 0; border-top: 1px solid rgba(51, 65, 85, 0.4); background: radial-gradient(ellipse at 50% 0%, rgba(245, 158, 11, 0.05), transparent);">
    <div class="container-custom">
        <!-- Centered Header with Impact -->
        <div style="text-align: center; max-width: 50rem; margin: 0 auto 3.5rem auto;">
            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1rem;">
                <span style="width: 2rem; height: 1px; background: linear-gradient(90deg, transparent, #fbbf24);"></span>
                <span style="color: #fbbf24; font-size: 0.7rem; font-weight: 600; letter-spacing: 0.2em;">GOVERNANCE PIPELINE</span>
                <span style="width: 2rem; height: 1px; background: linear-gradient(90deg, #fbbf24, transparent);"></span>
            </div>
            <h2 style="font-size: clamp(2rem, 5vw, 3rem); font-weight: 800; line-height: 1.2; margin-bottom: 1rem;">
                From submission to 
                <span class="gradient-text" style="display: inline-block;">verifiable proof</span>
            </h2>
            <p style="color: #94a3b8; font-size: 1rem; max-width: 38rem; margin: 0 auto;">
                AI + human oversight + cryptographic verification — seamless institutional integrity.
            </p>
        </div>
        
        <!-- Elegant Workflow Grid -->
        <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; position: relative;">
            <!-- Connecting Line Background (Desktop) -->
            <div style="position: absolute; top: 2.5rem; left: 10%; right: 10%; height: 2px; background: linear-gradient(90deg, rgba(245, 158, 11, 0.2), rgba(56, 189, 248, 0.4), rgba(168, 85, 247, 0.4), rgba(245, 158, 11, 0.2), rgba(34, 197, 94, 0.4)); display: none; @media (min-width: 1024px) { display: block; }"></div>
            
            <!-- Step 1 -->
            <div class="glass-card" style="padding: 1.5rem 0.75rem; text-align: center; position: relative; z-index: 2;">
                <div style="width: 3rem; height: 3rem; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <span style="font-weight: 800; color: #fbbf24;">1</span>
                </div>
                <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Request</div>
                <div style="font-size: 0.75rem; color: #94a3b8;">Secretary submits verification request</div>
            </div>
            
            <!-- Step 2 -->
            <div class="glass-card" style="padding: 1.5rem 0.75rem; text-align: center;">
                <div style="width: 3rem; height: 3rem; background: rgba(56, 189, 248, 0.15); border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <span style="font-weight: 800; color: #7dd3fc;">2</span>
                </div>
                <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Gemma Reasoning</div>
                <div style="font-size: 0.75rem; color: #94a3b8;">Local LLM audits policy rules</div>
            </div>
            
            <!-- Step 3 -->
            <div class="glass-card" style="padding: 1.5rem 0.75rem; text-align: center;">
                <div style="width: 3rem; height: 3rem; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <span style="font-weight: 800; color: #c084fc;">3</span>
                </div>
                <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Risk Scoring</div>
                <div style="font-size: 0.75rem; color: #94a3b8;">Confidence + anomaly detection</div>
            </div>
            
            <!-- Step 4 -->
            <div class="glass-card" style="padding: 1.5rem 0.75rem; text-align: center;">
                <div style="width: 3rem; height: 3rem; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <span style="font-weight: 800; color: #fbbf24;">4</span>
                </div>
                <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Human Governance</div>
                <div style="font-size: 0.75rem; color: #94a3b8;">Manager review for high-risk</div>
            </div>
            
            <!-- Step 5 -->
            <div class="glass-card" style="padding: 1.5rem 0.75rem; text-align: center;">
                <div style="width: 3rem; height: 3rem; background: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.3); border-radius: 1rem; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem auto;">
                    <span style="font-weight: 800; color: #86efac;">5</span>
                </div>
                <div style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1rem;">Zero-Knowledge Verification</div>
                <div style="font-size: 0.75rem; color: #94a3b8;">Privacy-preserving audit</div>
            </div>
        </div>
        
        <!-- Responsive: Stack on mobile -->
        <style>
            @media (max-width: 768px) {
                .workflow-grid-responsive {
                    grid-template-columns: 1fr !important;
                    gap: 1rem !important;
                }
                .workflow-grid-responsive > div {
                    max-width: 280px;
                    margin: 0 auto;
                    width: 100%;
                }
            }
        </style>
        
        <!-- Bottom tagline -->
        <div style="text-align: center; margin-top: 3rem;">
            <div style="display: inline-flex; align-items: center; gap: 1.5rem; background: rgba(255,255,255,0.02); padding: 0.5rem 1.5rem; border-radius: 2rem;">
                <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: #64748b;">
                    <span style="width: 6px; height: 6px; background: #fbbf24; border-radius: 50%;"></span>
                    LOCAL FIRST
                </span>
                <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: #64748b;">
                    <span style="width: 6px; height: 6px; background: #7dd3fc; border-radius: 50%;"></span>
                    HUMAN OVERSIGHT
                </span>
                <span style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.7rem; color: #64748b;">
                    <span style="width: 6px; height: 6px; background: #86efac; border-radius: 50%;"></span>
                    ZK VERIFIED
                </span>
            </div>
        </div>
    </div>
</section>

    <!-- ===== GOVERNANCE SCENARIOS ===== -->
    <section style="padding: 3rem 0; background: rgba(7, 11, 23, 0.4); border-top: 1px solid rgba(51, 65, 85, 0.4); border-bottom: 1px solid rgba(51, 65, 85, 0.4);">
        <div class="container-custom">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="margin-bottom: 0.5rem;">Governance simulation scenarios</h2>
                <p style="color: #94a3b8; font-size: 0.875rem; max-width: 42rem; margin: 0 auto;">GotiHub AGL uses local Gemma reasoning to evaluate institutional verification requests</p>
            </div>
            <div class="scenarios-grid">
                <!-- Verified -->
                <div style="border-radius: 1rem; border-left: 4px solid #22c55e; background: linear-gradient(135deg, rgba(34, 197, 94, 0.05), transparent); padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(34, 197, 94, 0.15); color: #86efac; font-size: 0.7rem; font-weight: 600;">✅ VERIFIED</span>
                        <span style="font-size: 1.5rem;">📜</span>
                    </div>
                    <h3 style="margin-bottom: 0.75rem;">Apurba Singh</h3>
                    <div style="margin-bottom: 1rem; padding-left: 0.75rem; border-left: 2px solid rgba(34, 197, 94, 0.3);">
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🎓 Graduation: <strong style="color: white;">2010</strong></p>
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🆔 Student ID: <strong style="color: white;">ID-2010-AS-99</strong></p>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.3); border-radius: 0.75rem; padding: 0.875rem;">
                        <p style="color: #86efac; font-size: 0.7rem; font-weight: 600; margin-bottom: 0.5rem;">🧠 GEMMA ANALYSIS</p>
                        <p style="color: #94a3b8; font-size: 0.813rem; margin-bottom: 0.75rem;">ID pattern matches graduation schema. No anomalies detected.</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                            <span style="color: #64748b; font-size: 0.7rem;">Risk Score</span>
                            <div class="risk-bar"><div class="risk-fill" style="width: 0%; background: #22c55e;"></div></div>
                            <span style="color: #86efac; font-weight: 600; font-size: 0.813rem;">0%</span>
                        </div>
                    </div>
                </div>
                <!-- Flagged -->
                <div style="border-radius: 1rem; border-left: 4px solid #f59e0b; background: linear-gradient(135deg, rgba(245, 158, 11, 0.05), transparent); padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(245, 158, 11, 0.15); color: #fcd34d; font-size: 0.7rem; font-weight: 600;">⚠️ FLAGGED</span>
                        <span style="font-size: 1.5rem;">⚠️</span>
                    </div>
                    <h3 style="margin-bottom: 0.75rem;">Mr. Fraudulent</h3>
                    <div style="margin-bottom: 1rem; padding-left: 0.75rem; border-left: 2px solid rgba(245, 158, 11, 0.3);">
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🎓 Graduation: <strong style="color: white;">1995</strong></p>
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🆔 Student ID: <strong style="color: white;">ID-2026-NEW-01</strong></p>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.3); border-radius: 0.75rem; padding: 0.875rem;">
                        <p style="color: #fcd34d; font-size: 0.7rem; font-weight: 600; margin-bottom: 0.5rem;">⚠️ GEMMA ANALYSIS</p>
                        <p style="color: #94a3b8; font-size: 0.813rem; margin-bottom: 0.75rem;">Mismatch: 1995 graduate with 2026 ID pattern. Escalate.</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                            <span style="color: #64748b; font-size: 0.7rem;">Risk Score</span>
                            <div class="risk-bar"><div class="risk-fill" style="width: 78%; background: #f59e0b;"></div></div>
                            <span style="color: #fcd34d; font-weight: 600; font-size: 0.813rem;">78%</span>
                        </div>
                    </div>
                </div>
                <!-- Rejected -->
                <div style="border-radius: 1rem; border-left: 4px solid #ef4444; background: linear-gradient(135deg, rgba(239, 68, 68, 0.05), transparent); padding: 1.25rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; background: rgba(239, 68, 68, 0.15); color: #fca5a5; font-size: 0.7rem; font-weight: 600;">❌ REJECTED</span>
                        <span style="font-size: 1.5rem;">❌</span>
                    </div>
                    <h3 style="margin-bottom: 0.75rem;">Unknown User</h3>
                    <div style="margin-bottom: 1rem; padding-left: 0.75rem; border-left: 2px solid rgba(239, 68, 68, 0.3);">
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🎓 Graduation: <strong style="color: white;">ABCD</strong></p>
                        <p style="color: #cbd5e1; font-size: 0.813rem;">🆔 Student ID: <strong style="color: white;">0000</strong></p>
                    </div>
                    <div style="background: rgba(0, 0, 0, 0.3); border-radius: 0.75rem; padding: 0.875rem;">
                        <p style="color: #fca5a5; font-size: 0.7rem; font-weight: 600; margin-bottom: 0.5rem;">🧠 GEMMA ANALYSIS</p>
                        <p style="color: #94a3b8; font-size: 0.813rem; margin-bottom: 0.75rem;">Invalid format: graduation year schema validation failed.</p>
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem;">
                            <span style="color: #64748b; font-size: 0.7rem;">Risk Score</span>
                            <div class="risk-bar"><div class="risk-fill" style="width: 100%; background: #ef4444;"></div></div>
                            <span style="color: #fca5a5; font-weight: 600; font-size: 0.813rem;">100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SYSTEM ARCHITECTURE ===== -->
    <section style="padding: 3rem 0;">
        <div class="container-custom">
            <div style="text-align: center; margin-bottom: 2rem;">
                <h2 style="margin-bottom: 0.5rem;">Governance architecture</h2>
                <p style="color: #94a3b8; font-size: 0.875rem;">Local AI reasoning, policy enforcement, and Zero-Knowledge verification</p>
            </div>
            <div class="features-grid">
                <div class="glass-card" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🧠</div>
                    <h3 style="margin-bottom: 0.5rem;">Gemma 4</h3>
                    <p style="color: #94a3b8; font-size: 0.813rem;">Local reasoning engine via Ollama</p>
                </div>
                <div class="glass-card" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">⚖️</div>
                    <h3 style="margin-bottom: 0.5rem;">Laravel AGL</h3>
                    <p style="color: #94a3b8; font-size: 0.813rem;">Policies, rules & risk escalation</p>
                </div>
                <div class="glass-card" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">👨‍💼</div>
                    <h3 style="margin-bottom: 0.5rem;">Human Approval</h3>
                    <p style="color: #94a3b8; font-size: 0.813rem;">Critical decisions under control</p>
                </div>
                <div class="glass-card" style="padding: 1.5rem; text-align: center;">
                    <div style="font-size: 2rem; margin-bottom: 0.75rem;">🔐</div>
                    <h3 style="margin-bottom: 0.5rem;">Midnight Proof</h3>
                    <p style="color: #94a3b8; font-size: 0.813rem;">ZK audit without exposing data</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LIVE DEMO ===== -->
    <section style="padding: 3rem 0; border-top: 1px solid rgba(51, 65, 85, 0.4);">
        <div class="container-custom">
            <div class="glass-card" style="padding: 2rem; text-align: center;">
                <h2 style="margin-bottom: 0.75rem;">Live Governance Demo</h2>
                <p style="color: #94a3b8; font-size: 0.875rem; max-width: 36rem; margin: 0 auto 1.5rem auto;">Explore the dashboard, AI reasoning, risk engine, and Midnight verification</p>
                <div style="background: rgba(0, 0, 0, 0.4); border-radius: 0.75rem; padding: 1rem; max-width: 24rem; margin: 0 auto 1.5rem auto; text-align: left;">
                    <p style="color: #cbd5e1; font-size: 0.75rem; margin-bottom: 0.5rem;"><strong>Demo URL:</strong><br>http://152.42.168.170:8080/admin/login</p>
                    <p style="color: #cbd5e1; font-size: 0.75rem; margin-bottom: 0.25rem;"><strong>Email:</strong> apurbansinghdev@gmail.com</p>
                    <p style="color: #cbd5e1; font-size: 0.75rem;"><strong>Password:</strong> Mid@Night@day@026</p>
                </div>
                <a href="http://152.42.168.170:8080/admin/login" class="btn-primary" style="display: inline-flex;">Access Dashboard →</a>
            </div>
        </div>
    </section>

    <!-- ===== FOOTER ===== -->
    <footer style="border-top: 1px solid rgba(51, 65, 85, 0.4); padding: 1.5rem 0;">
        <div class="container-custom" style="display: flex; flex-direction: column; align-items: center; gap: 0.75rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <div style="width: 1.75rem; height: 1.75rem; border-radius: 0.5rem; background: linear-gradient(135deg, #f59e0b, #38bdf8); display: flex; align-items: center; justify-content: center;">
                    <span style="color: #000; font-weight: 900; font-size: 0.75rem;">G</span>
                </div>
                <span style="color: #64748b; font-size: 0.75rem;">Built with Laravel 13, Gemma 4, Midnight & Docker</span>
            </div>
            <div style="color: #94a3b8; font-weight: 500; font-style: italic; font-size: 0.75rem;">“AI can recommend. Governance decides.”</div>
        </div>
    </footer>

</body>
</html>