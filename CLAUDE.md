# 🤖 AI Agent Instruction – Laravel Livewire Project

## 📌 Project Overview

This project is built using:

* **Laravel 12/13**
* **Livewire (SPA-like behavior)**
* **Tailwind CSS**
* **Vite (Frontend build tool)**

هدف utama:

* Clean UI (modern dashboard style)
* Reusable components
* Efficient CRUD operations
* Smooth SPA experience (no full reload)

---

## 🧠 Coding Philosophy

AI Agent MUST follow:

1. **Clean & readable code**
2. **Minimal but powerful logic**
3. **Component-based architecture (Livewire)**
4. **Avoid unnecessary complexity**
5. **Follow Laravel conventions strictly**

---

## 🧱 Project Structure Rules

### Backend (Laravel)

* Business logic → `app/Services`
* Models → `app/Models`
* Controllers → only if needed (prefer Livewire)
* Validation → inside Livewire or Form Request

### Frontend (Livewire + Blade)

* Use **Livewire components** for interactive features
* Use **Blade components** for reusable UI
* Avoid inline logic in Blade

---

## ⚡ Livewire Rules

1. Use Livewire for:

   * CRUD
   * Filtering
   * Pagination
   * Modal interactions

2. Avoid:

   * Full page reload
   * jQuery (NOT allowed)

3. Prefer:

   * `wire:model`
   * `wire:click`
   * `wire:loading`

---

## 🎨 UI / UX Guidelines

* Use **Tailwind CSS only**
* Design must be:

  * Clean
  * Soft colors (emerald / teal preferred)
  * Rounded (2xl)
  * Shadow-based cards

### Layout Standard

* Use `<x-app-layout>`
* Header with gradient
* Card-based content
* Table with:

  * Hover effect
  * Status badge
  * Action buttons

---

## 📊 Table Design Rules

Every table MUST include:

* Search
* Filter (if applicable)
* Pagination
* Action column (Edit, Delete, View)

---

## 🔐 Authentication

* Use Laravel built-in auth (starter kit)
* Protect routes with middleware
* No custom auth unless requested

---

## 🗃️ Database Rules

* Use migrations properly
* Always include:

  * `timestamps()`
* Naming:

  * snake_case for columns
  * singular for models

---

## 🚀 Performance Rules

* Use eager loading (`with()`)
* Avoid N+1 queries
* Use pagination ALWAYS for large data

---

## 🧪 Development Workflow

When generating features:

1. Create Migration
2. Create Model
3. Create Livewire Component
4. Create Blade View
5. Add Routing
6. Test functionality

---

## ❗ DO NOT

* Do not use jQuery
* Do not use inline CSS
* Do not break Laravel conventions
* Do not create unnecessary controllers
* Do not use global JS unless needed

---

## ✅ Preferred Patterns

### CRUD

Use:

* Livewire component per module
* Modal form (optional)
* Real-time validation

### Forms

* Use `wire:model.defer`
* Show error messages clearly

---

## 💡 Naming Convention

| Item      | Format       |
| --------- | ------------ |
| Model     | Donor        |
| Table     | donors       |
| Component | DonorManager |
| Variable  | `$donor`     |

---

## 🔥 Special Notes (Important)

This project may include:

* Donor Management System
* Payment Tracking
* Image Upload (proof of transfer)
* Status Filtering

AI Agent should:

* Prioritize clarity of data
* Provide user-friendly UI
* Keep admin workflow efficient

---

## 🧭 Goal of AI Agent

Help developer:

* Build features faster
* Maintain clean architecture
* Avoid bugs
* Follow best practices

---

## ✨ Output Expectations

Every generated code must be:

* Ready to use
* Clean & formatted
* Following this instruction strictly

---

**END OF FILE**
