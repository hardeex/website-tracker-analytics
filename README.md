
# Laravel Analytics Tracker – Easy Integration Guide

This is a plug-and-play analytics tracking system that works for **any website**. No complex setup. Just copy-paste and start tracking **page views**, **clicks**, and **session time** with detailed analytics.

---

## Features

- Simple setup
- Auto-tracks every page view and click
- Tracks how long users stay on each page
- Breakdowns by country, traffic, top pages
- API access to full analytics
- No dependencies – pure Vanilla JavaScript

---

## 🧩 How It Works

1. Register your website
2. Get a unique `api_key`
3. Paste a tracking script on your site - Prefeerably your base or index layout
4. Done! Analytics starts flowing ✨

---

## 🛠️ Step 1: Register Your Website

Make a `POST` request to register your site.

### ➤ Endpoint:
```

POST [https://analytics.essentialnews.ng/api/sites](https://analytics.essentialnews.ng/api/sites)

````

### Sample Request (via Postman or Terminal):
```bash
curl -X POST https://analytics.essentialnews.ng/api/sites \
  -H "Content-Type: application/json" \
  -d '{
    "domain": "https://yourwebsite.com",
    "name": "My Website"
}'
````

### Response:

```json
{
  "site": {
    "api_key": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
  },
  "tracking_code": "<script src=\"https://analytics.essentialnews.ng/api/tracker.js?api_key=xxxxxxxx\"></script>"
}
```

---

## 🔧 Step 2: Add the Script to Every Page

Paste the script tag just before `</body>` or in the `<head>` of your site.

### HTML Example:

```html
<!-- Add this to all your pages -->
<script src="https://analytics.essentialnews.ng/api/tracker.js?api_key=xxxxxxxx"></script>
```

 **Pro Tip:** If your site uses a layout template (e.g. Laravel Blade, React layout, etc.), paste it once in the layout to apply everywhere.

---

##  What It Tracks Automatically

| Event              | Trigger      | Extra Info Sent          |
| ------------------ | ------------ | ------------------------ |
| `pageview`         | On page load | URL, browser, IP         |
| `click`            | On any click | `element_id` (if exists) |
| `session_duration` | On unload    | Seconds spent on page    |

No extra setup. Just the script = full tracking. 🚀

---

## Optional: Track Custom Events

Want to track something manually? Use:

```js
window.tracker?.track('click', { element_id: 'my-button' });

window.tracker?.track('pageview', { session_duration: 90 });
```

---

## Step 3: View Your Analytics

To get a full report of views, clicks, top pages, and visitors:

### ➤ Endpoint:

```
GET https://analytics.essentialnews.ng/api/analytics?api_key=xxxxxxxx
```

It returns:

* Daily breakdowns (today, week, month)
* Top countries
* Top pages
* Unique visitors

Use this data to build a dashboard or show insights.

---

## Want to Inspect Events?

Open DevTools in your browser:

1. Go to **Network → Fetch/XHR**
2. You’ll see calls to `/api/track`
3. You’re live! 🔴

---

## Common Errors

| Issue               | Fix                                                |
| ------------------- | -------------------------------------------------- |
| `Invalid API key`   | Ensure your script tag has the correct key         |
| `Validation failed` | Missing required fields or wrong format            |
| `page_url mismatch` | Only pages from the registered domain are accepted |

---

## Safety Notes

* Your site must be accessible via HTTPS (for accurate IP/location).
*  Do **not** expose your analytics API key in public if you're tracking sensitive data.
* CORS must be properly configured if using across origins.

---

## Quick Summary

1. Register your site to get an API key
2. Paste the script in your site layout
3. Done! Tracking is automatic
4. View analytics via the `/analytics` endpoint

---

Made with ❤️ using Laravel, JavaScript, and common sense.

Need help? Open an issue or contact the developer - webmasterjdd@gmail.com.

```

