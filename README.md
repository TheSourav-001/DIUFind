# 🔍 DIUfind - Smart Lost & Found System

**DIUfind** is a modern, feature-rich web platform designed for the **Daffodil International University (DIU)** community to efficiently report, track, and recover lost items on campus. It combines a sleek UI with powerful features like an interactive map, and gamification to foster a supportive and honest community.

---

## ✨ Key Features

### 📦 Item Management
- **Report Lost/Found Items**: Easily post about items with titles, descriptions, categories, and images.
- **Advanced Filtering**: Search for items by type (Lost/Found), category, location, and date range.
- **Resolved Status**: Mark items as "Resolved" once they are found or returned to their rightful owner.

### 🗺️ Interactive Campus Map
- **Live Lost & Found**: View an interactive map of the campus with markers showing exactly where items were reported.
- **Visual Markers**: Hover or click markers to see quick details and images of lost/found items.

### 🏆 Gamification & Trust System
- **Honesty Points**: Earn points by reporting found items and successfully returning them to owners.
- **Campus Heroes**: Compete in the **Hall of Fame** (Leaderboard) to become a top contributor.
- **Badges**: Unlock unique badges based on your activity and helpfulness in the community.

### 💬 Social & Interaction
- **Discussion System**: Comment on posts to provide more details or ask questions.
- **Reactions**: Interact with posts using quick reactions to show support.
- **Claim System**: Owners can securely claim their lost items, followed by verification from the founder.

### 🔔 Notifications & Tools
- **Real-time Alerts**: Get notified when someone comments on your post or when your item is claimed.
- **PDF Poster Export**: Generate professional "Lost/Found" posters automatically for physical notice boards.
- **Personalized Analytics**: Track your impact with a detailed profile dashboard and downloadable activity reports.

---

## 🛠️ Technical Stack

- **Backend**: PHP (Custom MVC Framework)
- **Database**: MySQL with PDO (Safe against SQL Injection)
- **Frontend**: HTML5, CSS3 (Modern Glassmorphism Design), JavaScript
- **Libraries**:
    - **AOS**: Scroll animations for a premium feel.
    - **Font Awesome**: High-quality vector icons.
    - **SweetAlert2**: Beautiful custom alerts and modals.
    - **FPDF**: Dynamic PDF generation for posters and reports.

---

## 🚀 Getting Started

### Prerequisites
- PHP 7.4 or higher
- MySQL / MariaDB
- Apache Web Server (XAMPP / WAMP recommended)

### Installation
1.  **Clone the Repository**:
    ```bash
    git clone https://github.com/TheSourav-001/DIUFind.git
    ```
2.  **Database Setup**:
    - Import `app/config/diufind_db.sql` into your PHPMyAdmin or local MySQL server.
3.  **Config Setup**:
    - Update `app/config/config.php` and `app/config/Database.php` with your local database credentials and URL root.
4.  **Launch**:
    - Move the project to your `htdocs` folder and access it via `http://localhost/DIUfind`.

---

## 🛡️ Security Features
- **PDO Prepared Statements**: Protects against SQL injection attacks.
- **Password Hashing**: Uses `PASSWORD_DEFAULT` for secure user authentication.
- **Ownership Verification**: Strict checks to ensure only post authors can manage their content.

---

## 👨‍💻 Developed By
**Sourav Dipto Apu**  
*Passionate about building community-driven solutions.*

---
*DIUfind - Bridging the gap between lost and found.*
