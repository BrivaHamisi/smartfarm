---
name: SmartFarm
description: Fresh, modern smart-agriculture platform — urgent public red, calm operational green.
colors:
  primary: "#0d8a4e"
  signal: "#FF2D20"
  signal-hover: "#e02717"
  signal-active: "#c81f12"
  success: "#16a34a"
  danger: "#dc2626"
  warning: "#d97706"
  neutral-gray: "#5b6472"
  page-bg: "#f9fafb"
  surface: "#ffffff"
  ink: "#111827"
  muted: "#6b7280"
  form-label: "#374151"
  border: "#e5e7eb"
  table-header: "#475569"
typography:
  display:
    fontFamily: "Figtree, ui-sans-serif, system-ui, sans-serif"
    fontSize: "clamp(2.25rem, 6vw, 3.75rem)"
    fontWeight: 700
    lineHeight: 1.05
    letterSpacing: "-0.02em"
  headline:
    fontFamily: "Figtree, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "normal"
  title:
    fontFamily: "Figtree, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.125rem"
    fontWeight: 600
    lineHeight: 1.3
    letterSpacing: "normal"
  body:
    fontFamily: "Figtree, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.5
    letterSpacing: "normal"
  label:
    fontFamily: "Figtree, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.72rem"
    fontWeight: 500
    lineHeight: 1.2
    letterSpacing: "0.05em"
rounded:
  controls: "8px"
  sidebar: "10px"
  tiles: "12px"
  cards: "16px"
  pill: "9999px"
spacing:
  xs: "4px"
  sm: "8px"
  md: "16px"
  lg: "24px"
  xl: "48px"
components:
  button-primary:
    backgroundColor: "{colors.signal}"
    textColor: "{colors.surface}"
    rounded: "{rounded.controls}"
    padding: "12px 24px"
  button-primary-hover:
    backgroundColor: "{colors.signal-hover}"
  button-primary-active:
    backgroundColor: "{colors.signal-active}"
  button-dashboard-primary:
    backgroundColor: "{colors.primary}"
    textColor: "{colors.surface}"
    rounded: "{rounded.controls}"
    padding: "8px 14px"
  button-secondary:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.controls}"
    padding: "12px 24px"
  input-field:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.controls}"
    padding: "12px 16px"
    height: "48px"
  card-surface:
    backgroundColor: "{colors.surface}"
    textColor: "{colors.ink}"
    rounded: "{rounded.cards}"
    padding: "24px"
  chip-pill:
    backgroundColor: "rgba(255, 45, 32, 0.10)"
    textColor: "{colors.ink}"
    rounded: "{rounded.pill}"
    padding: "8px 16px"
---

# Design System: SmartFarm

## Overview

**Creative North Star: "The Farmhand's Toolkit"**

SmartFarm is a two-surface system: a vivid public world that recruits, and a calm operational world that runs the farm. The public surface is bright, energetic agri-tech — Signal Red action against light-gray whitespace, bold confident copy, and feature cards that feel modern and approachable. The operational surface — the Filament dashboard and generated PDF documents — is serene and precise: Pasture Green primary actions, quiet grays, and money that is always legible at a glance.

The personality is fresh, modern, and lean — a startup-grade product with a farmer's practicality at heart. Generous whitespace, rounded corners, and a single modern grotesque typeface (Figtree) carry the whole system without a display-contrast pairing, so nothing stands between the operator and the record. Components are refined and restrained: hairline borders, soft layered shadows, and quiet grays mean only genuine primary actions ever wear brand color. The two accents never compete — Signal Red is locked to public/auth screens, Pasture Green to operations. The shift from red to green is the product story: *we get your attention; then we give you order.* The system's working motto, inherited from the login screen, says it plainly: **MONITOR • ANALYZE • OPTIMIZE**.

**Key Characteristics:**
- Two-surface color contract: Signal Red for public persuasion, Pasture Green for operations and money.
- Fresh agri-tech atmosphere: bright accents, generous whitespace, rounded corners, approachable copy.
- Refined and restrained components: hairline borders, soft layered shadows, quiet grays.
- Money is always green ink (income, net positive) or red ink (expenses, losses), prefixed "KSh".
- Micro-labels are uppercase with wide tracking on table headers and PDF documents.
- Figtree alone; no display-contrast type pairing.

## Colors

Two warm brand accents — a vivid Signal Red and a deep Pasture Green — sit on a quiet gray-and-white neutral base.

### Primary
- **Pasture Green** (#0d8a4e): the operational brand. Filament primary (dashboard buttons, links, active nav, notifications, focus rings), the PDF brand mark/rules/titles, and all positive money figures. Green means "system, record, value."

### Secondary
- **Signal Red** (#FF2D20): the public/auth surface hero. Primary CTA buttons, the logo mark, focus rings, links, and the login gradient overlay. Hover #e02717, active #c81f12. Red means "act here."

### Tertiary
- **Success** (#16a34a): income/positive deltas outside money figures and affirmative states.
- **Danger** (#dc2626): destructive actions, errors, expenses, losses.
- **Warning** (#d97706): attention states and pending figures.

### Neutral
- **Neutral Gray** (#5b6472): the Filament neutral — grays the dashboard shell.
- **Page Ground** (#f9fafb): light-gray canvas for public pages and the auth form half (gradient to #f3f4f6).
- **Surface** (#ffffff): cards, inputs, nav bars, stat cells.
- **Ink** (#111827): primary text on light grounds.
- **Muted** (#6b7280): secondary text, descriptions, PDF metadata.
- **Border** (#e5e7eb): hairline separators and card outlines.

### Named Rules
**The Two-Surface Rule.** Signal Red and Pasture Green are surface-locked. Public/auth screens lead with red on light gray; the dashboard and PDFs lead with green. Never blend both brand accents on one screen.

**The Green-Ink Rule.** Positive money (income, net income, yields) is Pasture Green; negative money (expenses, losses) is danger #dc2626. Currency is always "KSh".

**The Quiet-Neutral Rule.** Neutrals stay in the gray-50→gray-900 / slate family. Muted text is #6b7280; secondary actions are white with a gray-200 border. A screen's calm is the point.

## Typography

**Display Font:** Figtree (with ui-sans-serif / system-ui / sans-serif fallback)
**Body Font:** Figtree (with ui-sans-serif / system-ui / sans-serif fallback)
**Label/Mono Font:** none distinct — PDF documents render with DejaVu Sans under dompdf

**Character:** One modern grotesque sans — Figtree — friendly, open, and legible at the small sizes a busy farm dashboard demands. Hierarchy is carried by weight and size, never by a second font; tightened tracking on large headings keeps the big public copy confident, while wide-tracked uppercase micro-labels keep dense tables scannable.

### Hierarchy
- **Display** (700, `clamp(2.25rem, 6vw, 3.75rem)`, line-height 1.05, tracking -0.02em): public hero headline ("Transform Your Farm with Smart Technology") and the auth split-screen headline ("Smart Farm").
- **Headline** (700, 1.5rem, line-height 1.2): section and block headings.
- **Title** (600, 1.125rem, line-height 1.3): feature-card titles, the dashboard brand wordmark (~1.05rem, tracking-tight).
- **Body** (400, 0.875–1rem, line-height 1.5): page copy and descriptions, muted gray, max width ~38rem.
- **Label** (500, 0.72rem, uppercase, tracking 0.05em): table headers and dashboard micro-labels; PDF field labels are 9px with 0.08em tracking; auth kicker "WELCOME BACK" is text-sm with wider tracking.

### Named Rules
**The Uppercase Micro-Label Rule.** Column headers, PDF field labels, and kickers are uppercase, 0.72rem (PDF 9px), weight 500–600, letter-spacing 0.05em or wider. Never apply this treatment to body copy.

## Layout

- **Public pages:** full-viewport; a `max-w-7xl` container with `px-6`; hero on an `lg:grid-cols-2` grid with `gap-12`; vertical section rhythm `py-24`; feature cards in two staggered columns using small translate offsets.
- **Auth:** split-screen — the left half is a full-bleed image with a Signal Red gradient overlay and white copy; the right half is a gray-50→gray-100 gradient field holding a white form card (`max-w-md`, padding 24–32px).
- **Dashboard:** the Filament app shell — a collapsible sidebar (collapses to icons on desktop), a top bar separated by a 1px shadow, stacked content sections, and a responsive 4-column stat row that reflows on smaller widths.
- **PDF documents:** A4, 32px page padding, a header brand row (mark + wordmark left, reporting period right), a 4-column stat strip with 6px cell gutters, then full-width itemized tables.
- **Spacing rhythm:** the Tailwind 4px scale. `gap-4/6/12` between blocks, `space-y-6` inside forms, `p-6` card padding, `px-6 py-3` primary buttons.
- **Responsive:** `lg` (1024px) is the pivot for public layouts — the image half of auth appears only at `lg+`; the dashboard reflows through Filament's own column system.

## Elevation & Depth

Softly layered: surfaces are flat at rest, and depth is conveyed by tonal tints plus a small set of ambient shadows. This is a "quiet lift," never a shadow playground.

- **Tonal layering:** the active sidebar item tints the primary green at 12% alpha (18% in dark mode) with a 3px inset green bar; PDF stat cells use 3–6% tinted fills with matching hairline borders; error inputs sit on red-50.
- **Ambient shadows:** stat cards and dashboard sections carry a two-layer soft shadow (below); the auth form uses a single hairline `shadow-sm`. In dark mode all shadows are dropped and surfaces separate with white/8% borders.

### Shadow Vocabulary
- **stat-card** (`box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 8px 24px -12px rgb(15 23 42 / 0.12)`): dashboard stat overview cards.
- **section** (`box-shadow: 0 1px 2px rgb(15 23 42 / 0.04), 0 12px 28px -16px rgb(15 23 42 / 0.10)`): dashboard content sections and tables.
- **form-card** (`box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05)`): the auth form card.
- **topbar** (`box-shadow: 0 1px 0 0 rgb(0 0 0 / 0.04)`): the dashboard top bar hairline.
- **hover-lift** (`transform: translateY(-4px)`): public feature cards rise on hover over a 150ms ease transition.

### Named Rules
**The Flat-By-Default Rule.** Shadows only separate top-level surfaces (stat cards, sections, forms). In dark mode shadows are dropped and surfaces separate by borders alone. Never stack heavy or colored shadows.

## Shapes

A soft, approachable form language with a consistent rounding ladder. Controls and inputs are gently curved at 8px (`rounded-lg`); stat/icon tiles round at 12px (`rounded-xl`) and sidebar items at 10px; large public cards round at 16px (`rounded-2xl`); pills and badges are fully round. Surfaces are outlined by hairline 1px borders — gray-200 on public cards, 6%-alpha slate on dashboard stat cards, white/8% in dark mode — and PDF documents use 2px Pasture Green rules for emphasis. The only decorative geometry is the slow-rotating ring trio on the auth hero; everywhere else the silhouette follows the content.

## Components

### Buttons
- **Shape:** 8px radius (`rounded-lg`), ~44–48px tall, weight 500–600.
- **Primary (public):** Signal Red fill, white text, `px-6 py-3`. Hover #e02717, active #c81f12, 2px Signal Red focus ring with white offset, disabled at 70% opacity. On submit the label swaps to a status word and an inline spinner appears.
- **Primary (dashboard):** Pasture Green fill, white text, `px-3.5 py-2`, Filament's default primary focus ring.
- **Secondary / Ghost (public):** white fill, gray-900 text, gray-200 border; hover flips to gray-50.

### Chips / Pills
- **Style:** translucent accent tint (Signal Red at 10%), gray-900 text, fully round, `px-4 py-2`; any badge icon inherits the accent color.
- **State:** informational — no selected/unselected variants in the incumbent system.

### Cards / Containers
- **Corner Style:** 16px on public feature cards, 12px on dashboard stat tiles, 8px on PDF stat cells.
- **Background:** white.
- **Shadow Strategy:** the softly layered set above; public feature cards additionally lift −4px on hover.
- **Border:** 1px gray-200 (public) / 6%-alpha slate (dashboard stats) / white 8% in dark.
- **Internal Padding:** 24px (`p-6`).

### Inputs / Fields
- **Style:** white, 1px gray-300 border, 8px radius, `px-4 py-3` (12px/16px), `shadow-sm`.
- **Focus:** 2px Signal Red ring at 25% alpha with the Signal Red border (public); Filament's primary ring on the dashboard.
- **Error:** red-400 border, red-50 background, red-600 message wired with `role="alert"` and `aria-describedby`.

### Navigation
- **Public:** a white bar with a gray-200 bottom border; logo mark + bold wordmark on the left, quiet links on the right, with the primary action expressed as the Signal Red button.
- **Dashboard sidebar:** quiet gray items, 10px radius, weight 500; the active item tints Pasture Green at 12–18% with a 3px inset green bar, and its label/icon shift to primary-700 (primary-400 in dark mode).

### Data Table Headers
- **Style:** uppercase micro-labels (0.72rem, tracking 0.05em, weight 500–600) in slate (`#475569` at ~85%; `#94a3b8` at ~85% in dark), set above a 2px bottom border (gray-200 on the dashboard; #e5e7eb rules on PDFs with 1px hairline cell rows).
- **Role:** the data surface's quiet workhorse — wide-tracked headers keep dense columns scannable without any color fill.

### PDF Document Shell
- **Masthead:** a 34px "SF" mark in Pasture Green (8px radius) beside the wordmark and a muted meta line, with the reporting period right-aligned.
- **Division:** a 2px Pasture Green rule separates the header from the stat strip; stat cells carry income-green / expense-red / neutral-gray tinted fills with matching hairline borders.
- **Footer:** centered 9px muted text — "Generated with SmartFarm · [farm] · [timestamp]".

### Signature Component: Money & Stat Language
The distinctive recurring pattern of the operations surface. Income, net positive, and yield figures are drawn in Pasture Green at weight 700; expenses and losses in #dc2626; each figure is prefixed "KSh" and set under an uppercase 0.72rem micro-label. Transactions carry explicit `+`/`−` signs. The exact same grammar renders on dashboard stat cards, the invoices, and the farm-report PDF.

## Do's and Don'ts

### Do:
- **Do** keep public pages on the light-gray ground with Signal Red as the only brand accent.
- **Do** use Pasture Green for every dashboard primary action, active nav state, and positive money figure.
- **Do** lead tables and PDF labels with uppercase micro-labels (0.72rem, 0.05em+ tracking).
- **Do** apply the softly layered shadow set verbatim (stat-card / section / form-card values).
- **Do** reference the frontmatter tokens when adding a color, radius, or padding to new screens.
- **Do** keep generated documents in the PDF shell: brand masthead, 2px Pasture Green rule, tinted stat cells, and the centered muted footer.

### Don't:
- **Don't** mix Signal Red and Pasture Green on the same screen.
- **Don't** add new brand accents or gradient fills (the auth hero overlay is the single exception).
- **Don't** stack heavy or colored shadows; in dark mode drop shadows entirely and separate by borders.
- **Don't** draw money in any color other than Pasture Green (positive) or #dc2626 (negative).
- **Don't** introduce a display-contrast type pairing; Figtree alone is the stack.
- **Don't** add emojis to the UI or to generated documents.
