# BarberBook 💈

A multi-salon online appointment booking platform built with **Laravel 12**, designed for barbershops and service-based salons.

BarberBook provides a complete workflow for salon management, public booking, QR-based salon access, appointment scheduling, booking tracking, and salon-level data isolation.

> **Project Status:** Production-oriented MVP / Active Development

---

## ✨ Overview

BarberBook is designed around a multi-salon architecture where every barber account belongs to its own salon and can manage only that salon's data.

Customers do **not** need to create an account to book an appointment.

### Booking Flow

```text
QR Code
   ↓
Public Salon Page
   ↓
Choose Service
   ↓
Choose Date
   ↓
Choose Available Time
   ↓
Enter Customer Information
   ↓
Create Booking
   ↓
Pending Approval
   ↓
Barber Approves / Rejects
   ↓
Customer Tracks Booking
