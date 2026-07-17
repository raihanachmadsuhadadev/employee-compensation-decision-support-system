# Compensation Decision Support System

Compensation Decision Support System adalah aplikasi web untuk membantu proses evaluasi karyawan, pengelolaan KPI, pembobotan kriteria, realisasi KPI, peer assessment, serta rekomendasi kenaikan gaji dan bonus berbasis sistem pendukung keputusan.

## Preview

### Login

![Login](docs/screenshots/01-login.png)

### Dashboard

![Dashboard](docs/screenshots/02-dashboard.png)

### User Management

![User Management](docs/screenshots/03-user-management.png)

### KPI Management

![KPI Management](docs/screenshots/04-kpi-management.png)

### AHP Weighting

![AHP Weighting](docs/screenshots/05-ahp-weighting.png)

### KPI Realization

![KPI Realization](docs/screenshots/06-kpi-realization.png)

### Peer Assessment

![Peer Assessment](docs/screenshots/07-peer-assessment.png)

### Compensation Recommendation

![Compensation Recommendation](docs/screenshots/08-compensation-recommendation.png)

## Key Features

- Authentication dan role-based access.
- Dashboard ringkasan evaluasi karyawan.
- Manajemen data user dan role.
- Manajemen divisi dan data karyawan.
- Manajemen KPI umum dan KPI divisi.
- Pembobotan kriteria menggunakan AHP.
- Input dan validasi realisasi KPI karyawan.
- Peer assessment antar karyawan.
- Perhitungan nilai akhir evaluasi.
- Rekomendasi kenaikan gaji.
- Rekomendasi bonus karyawan.
- Leaderboard performa karyawan dan divisi.
- Laporan hasil rekomendasi.

## Role Overview

### Owner / Management

- Melihat dashboard dan ringkasan evaluasi organisasi.
- Memantau data karyawan, KPI, dan realisasi performa.
- Melihat leaderboard karyawan dan divisi.
- Meninjau rekomendasi kenaikan gaji dan bonus sebagai bahan pengambilan keputusan.

### HR

- Mengelola data user, karyawan, divisi, KPI, dan aspek penilaian.
- Menentukan bobot prioritas kriteria menggunakan AHP.
- Meninjau dan memvalidasi realisasi KPI.
- Memantau peer assessment dan proses evaluasi kompensasi.
- Meninjau laporan rekomendasi kenaikan gaji dan bonus.

### Leader

- Melihat data dan performa anggota divisi.
- Mendistribusikan target KPI divisi.
- Mengisi atau meninjau realisasi KPI anggota divisi.
- Memantau leaderboard dan rekomendasi sesuai cakupan akses.

### Employee

- Melihat KPI, realisasi, dan hasil evaluasi miliknya sesuai akses.
- Mengisi peer assessment antar karyawan.
- Melihat leaderboard serta informasi rekomendasi yang tersedia.

## Decision Support Method

Sistem menghitung nilai evaluasi karyawan berdasarkan KPI, bobot kriteria, realisasi performa, dan peer assessment. Pembobotan menggunakan AHP agar tingkat kepentingan setiap kriteria dapat ditentukan secara terukur dan konsisten.

- KPI digunakan sebagai dasar evaluasi performa.
- AHP digunakan untuk menentukan bobot prioritas kriteria.
- Realisasi KPI digunakan untuk menghitung pencapaian karyawan.
- Peer assessment memberikan perspektif tambahan dalam penilaian.
- Nilai akhir membantu menghasilkan rekomendasi kenaikan gaji dan bonus.

Hasil yang diberikan merupakan rekomendasi pendukung keputusan dan tetap memerlukan pertimbangan pihak yang berwenang.

## Tech Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 12 |
| Frontend | Blade, Vite |
| Language | PHP 8.2+, JavaScript |
| Styling | Tailwind CSS, Bootstrap, Sneat UI |
| Database | PostgreSQL |
| Authentication | Custom Role-Based Authentication |
| Decision Support | AHP-based weighting and compensation recommendation |

## Project Structure

```text
employee-compensation-decision-support-system/
|-- app/
|-- database/
|-- public/
|-- resources/
|   `-- views/
|-- routes/
|-- docs/
|   `-- screenshots/
`-- README.md
```
