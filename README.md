# Analytics API Documentation

Welcome to the **Analytics API**, a powerful, privacy-focused, and developer-friendly solution for tracking website usage across multiple domains. Built with Laravel and secured by JWT authentication, this API lets you collect and retrieve data like page views, clicks, session duration, and visitor geolocation — **without relying on third-party tools like Google Analytics**.

Perfect for developers, agencies, and businesses managing websites like:
- `example.com`
- `edirect.ng`
- `essentialnews.ng`
- `estore.example.com`
- `ehotel.example.com`

---

## 📘 Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Why Use This API?](#why-use-this-api)
- [Getting Started](#getting-started)
  - [Step 1: Register an Account](#step-1-register-an-account)
  - [Step 2: Register Your Website](#step-2-register-your-website)
  - [Step 3: Add the Tracking Script](#step-3-add-the-tracking-script)
  - [Step 4: Retrieve Analytics Data](#step-4-retrieve-analytics-data)
- [API Endpoints](#api-endpoints)
- [Troubleshooting](#troubleshooting)
- [Admin & Super Admin Access](#admin--super-admin-access)
- [Contributing](#contributing)
- [Support](#support)

---

## 🔍 Overview
The Analytics API tracks and stores real-time usage data across your websites.

### Metrics Tracked:
- **Page Views** (daily, weekly, monthly, total)
- **Clicks** on specific elements (e.g. CTA buttons, links)
- **Session Duration** (time spent on site)
- **Geolocation** (country & city via MaxMind GeoLite2)

All data is associated with a specific registered website and securely tied to a user via JWT authentication.

---

## ✨ Features
- ✅ **Multi-site Support** – Monitor analytics across many domains
- 🔐 **JWT Authentication** – Secure API access with email verification
- 📊 **Custom Metrics** – Track exactly what matters (page views, clicks, sessions)
- 🌍 **Visitor Location Tracking** – Powered by MaxMind GeoLite2
- 🚀 **Scalable** – Built with Laravel, Redis queues, and database indexing
- 📦 **No External Dependencies** – You own the data; no Google, no tracking leaks
- 👥 **Admin View** – Aggregate analytics from all websites
- ⚖️ **GDPR/CCPA-Ready** – Consent management support

---

## 🚀 Getting Started

### ✅ Prerequisites
- Access to your website’s code (HTML/JavaScript)
- Text editor (e.g. VS Code)
- A modern browser (Chrome, Firefox)
- Optional: Postman or curl to test endpoints

---

### 🔐 Step 1: Register an Account

```bash
curl -X POST https://analytics.essentialnews.ng/api/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Your Name",
    "email": "your.email@example.com",
    "password": "YourPassword123",
    "password_confirmation": "YourPassword123",
    "marketing_consent": false
}'
```

📩 Check your email for a verification link (check spam/junk too).

### ✉️ Email Verification
```http
GET https://analytics.essentialnews.ng/api/verify-email?token=YOUR_VERIFICATION_TOKEN
```
**Response:**
```json
{
  "message": "Email verified successfully",
  "token": "your-jwt-token-here"
}
```
✅ Save the `token` — it's your **API key** for all authenticated requests.

### 🔁 Resend Verification Email
```bash
curl -X POST https://analytics.essentialnews.ng/api/resend-verification \
  -H "Content-Type: application/json" \
  -d '{"email": "your.email@example.com"}'
```

### 🔐 Log In to Refresh Token
```bash
curl -X POST https://analytics.essentialnews.ng/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "your.email@example.com",
    "password": "YourPassword123"
}'
```

**Response:**
```json
{
  "token": "your-new-jwt-token-here",
  "message": "Login successful"
}
```

---

### 🌐 Step 2: Register Your Website

```bash
curl -X POST https://analytics.essentialnews.ng/api/sites \
  -H "Authorization: Bearer your-jwt-token-here" \
  -H "Content-Type: application/json" \
  -d '{
    "domain": "edirect.example.com",
    "name": "Edirect"
}'
```

📌 Response:
```json
{
  "site": {
    "id": 1,
    "domain": "edirect.example.com",
    "name": "Edirect",
    "user_id": 1
  }
}
```

---

### 📈 Step 3: Add the Tracking Script

#### Option 1: Use Hosted Script
```html
<script src="https://analytics.essentialnews.ng/js/analytics.js"></script>
```

#### Option 2: Host It Yourself
Download and update the following:
```js
(function () {
  const apiUrl = 'https://analytics.essentialnews.ng/api';
  const jwtToken = 'YOUR_JWT_TOKEN';
  const domain = 'YOUR_WEBSITE_DOMAIN';

  function trackPageView(sessionDuration = null) {
    fetch(`${apiUrl}/track/pageview`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${jwtToken}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        domain: domain,
        page_url: window.location.href,
        user_agent: navigator.userAgent,
        session_duration: sessionDuration,
      }),
    });
  }

  function trackClick(elementId) {
    fetch(`${apiUrl}/track/click`, {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${jwtToken}`,
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        domain: domain,
        element_id: elementId,
        page_url: window.location.href,
        user_agent: navigator.userAgent,
      }),
    });
  }

  let pageLoadTime = Date.now();
  window.addEventListener('load', () => trackPageView());
  window.addEventListener('beforeunload', () => {
    const sessionDuration = Date.now() - pageLoadTime;
    trackPageView(sessionDuration);
  });

  document.addEventListener('click', (e) => {
    const element = e.target.closest('[data-track-id]');
    if (element) {
      trackClick(element.dataset.trackId);
    }
  });
})();
```

📎 Add to your site:
```html
<script src="/js/analytics.js"></script>
```

Track clicks:
```html
<button data-track-id="cta-button">Click Me</button>
<a href="/buy" data-track-id="buy-link">Buy Now</a>
```

✅ Open browser > DevTools > Network tab and look for POST requests to `/api/track/pageview` or `/api/track/click`.

---

### 📊 Step 4: Retrieve Analytics Data

```bash
curl -X GET https://analytics.essentialnews.ng/api/analytics/pageviews \
  -H "Authorization: Bearer your-jwt-token-here"
```

---

## ⚙️ API Endpoints

### 🔐 Authentication Routes
| Method | Endpoint                     | Description                            | Middleware    |
|--------|------------------------------|----------------------------------------|---------------|
| POST   | `/register`                  | Register a new user                    | None          |
| POST   | `/login`                     | Log in and receive JWT token           | None          |
| GET    | `/verify-email`              | Verify email with token                | None          |
| POST   | `/resend-verification-code`  | Resend email verification link         | None          |
| POST   | `/password-reset-request`    | Request password reset link            | None          |
| POST   | `/password-reset`            | Reset password                         | None          |
| GET    | `/logged-in-user`            | Get current user from JWT              | None          |
| POST   | `/logout`                    | Log out (JWT invalidation)             | `auth`        |
| POST   | `/change-password`           | Change password (authenticated)        | `auth`        |

### 🌐 Site Registration
| Method | Endpoint       | Description                    | Middleware |
|--------|----------------|--------------------------------|------------|
| POST   | `/sites`       | Register a website/domain      | `api.key`  |

### 📈 Tracking Routes
| Method | Endpoint              | Description                 | Middleware              |
|--------|-----------------------|-----------------------------|--------------------------|
| POST   | `/track/pageview`     | Track a page view           | `api.key`, `throttle`   |
| POST   | `/track/click`        | Track click on elements     | `api.key`, `throttle`   |

### 📊 Analytics Routes
| Method | Endpoint                           | Description                            | Middleware            |
|--------|------------------------------------|----------------------------------------|------------------------|
| GET    | `/analytics/pageviews`             | Get total page views                   | `api.key`, `throttle` |
| GET    | `/analytics/pageviews/by-page`     | Page views by specific URLs/pages      | `api.key`, `throttle` |
| GET    | `/analytics/session-duration`      | Average session duration               | `api.key`, `throttle` |
| GET    | `/analytics/geolocation`           | Get visitor geolocation                | `api.key`, `throttle` |
| GET    | `/analytics/clicks`                | Total clicks tracked                   | `api.key`, `throttle` |
| GET    | `/analytics/clicks/by-element`     | Clicks per element ID                  | `api.key`, `throttle` |

### 🔒 Admin Routes
| Method | Endpoint                     | Description                        | Middleware           |
|--------|------------------------------|------------------------------------|-----------------------|
| GET    | `/analytics/all-pageviews`   | Get all sites’ analytics (admin)   | `api.key`, `admin`    |

---

## 🧩 Troubleshooting
- ❌ **401 Unauthorized**: Make sure your JWT token is valid
- ❌ **403 Forbidden**: You’re not authorized for that action
- ❌ **No Tracking?**: Check browser console and network tab

---

## 🛠 For Administrators
Admins have access to:
- All sites’ data
- User management
- Global settings (e.g., max storage, geo sources)

---

## 🤝 Contributing
Pull requests are welcome! Please follow the contribution guide in `CONTRIBUTING.md`.

---

## 💬 Support
Need help?
- Email: webmasterjdd@gmail.com
- WhatsApp: +234-814-841-3982
- GitHub Issues: [Submit here](#)

---

**Built with ❤️ using Laravel, Redis, and MaxMind.**
