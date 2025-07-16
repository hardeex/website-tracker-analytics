
---

# Laravel Analytics Tracker – Easy Integration Guide

The **Laravel Analytics Tracker** is a plug-and-play analytics system for any website. With **minimal setup**, track:

Page Views
Clicks
Session Duration
Visitor Metrics (Total, New, Active, Returning, and Daily Visitors)

> No complex configuration — just copy, paste, and start tracking!

---

##  Features

* **Simple Setup**: One script tag and you're live.
* **Automatic Tracking**: Page views, clicks, and session duration.
* **Visitor Metrics**: Total, New, Active, Returning, and Daily.
* **Detailed Reports**: Time-based, by country, and top pages.
* **API Access**: Fetch analytics with an HTTP request.
* **No Dependencies**: Pure Vanilla JS — no jQuery or frameworks.
* **Backward Compatible**: Works on any existing site.

---

## How It Works

1. **Register**: Get your unique `api_key` and tracking script.
2. **Embed**: Add the script tag to your site.
3. **Track**: The tracker collects data automatically.
4. **Analyze**: Use the analytics API to fetch reports.
5. **Upgrade (Optional)**: Use the newer script for enhanced visitor metrics.

---

## Step 1: Register Your Website

**Endpoint:**

```
POST https://analytics.essentialnews.ng/api/sites
```

**Sample Request:**

```bash
curl -X POST https://analytics.essentialnews.ng/api/sites \
  -H "Content-Type: application/json" \
  -d '{
    "domain": "https://yourwebsite.com",
    "name": "My Website"
}'
```

**Sample Response:**

```json
{
  "status": "success",
  "message": "Site registered successfully",
  "site": {
    "id": 1,
    "domain": "https://yourwebsite.com",
    "name": "My Website",
    "api_key": "xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
  },
  "tracking_code": "<script src=\"https://analytics.essentialnews.ng/api/tracker.js?api_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx\"></script>"
}
```

> **Note**: Domain must be unique and served over HTTPS.

---

## 🔧 Step 2: Add the Tracking Script

Paste this script in your layout file (Blade, HTML, React, etc.):

```html
<script src="https://analytics.essentialnews.ng/api/tracker.js?api_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"></script>
```

> **Best Practice**: Add this in the `<head>` or right before `</body>` for full-page tracking.

**For Existing Users**: If you use `/api/process.js`, you're still tracking basic metrics. To unlock **visitor stats**, switch to `/api/tracker.js`.

---

## What It Tracks Automatically

| Event              | Trigger        | Data Sent                     |
| ------------------ | -------------- | ----------------------------- |
| `pageview`         | On page load   | URL, browser, IP, session\_id |
| `click`            | On any click   | element\_id (if available)    |
| `session_duration` | On page unload | Seconds spent on page         |

**Visitor Metrics** (with updated script):

* Total Visitors
* New Visitors
* Active Visitors
* Returning Visitors
* Daily Visitors

---

## Optional: Track Custom Events

Use the `tracker` object to fire events manually:

```js
// Track a button click
window.tracker?.track('click', { element_id: 'my-button' });

// Track custom pageview with duration
window.tracker?.track('pageview', { session_duration: 90 });
```

---

## Step 3: View Your Analytics

**Endpoint:**

```
GET https://analytics.essentialnews.ng/api/analytics?api_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx
```

**Sample Request:**

```bash
curl -X GET "https://analytics.essentialnews.ng/api/analytics?api_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
```

**Sample Response (Truncated):**

```json
{
  "status": "success",
  "data": {
    "domain": "https://yourwebsite.com",
    "all_time": {
      "views": [...],
      "clicks": [...],
      "top_pages": [...],
      "unique_visitors": 75,
      "new_visitors": 60,
      "returning_visitors": 15,
      "daily_visitors": [...],
      "by_country": [...]
    },
    "breakdowns": {
      "today": {...},
      "this_week": {...},
      "this_month": {...},
      "this_year": {...}
    }
  }
}
```

---

## Inspect & Debug

1. Open **DevTools** (F12).
2. Go to **Network → Fetch/XHR**.
3. Look for requests to `/api/track`.
4. Confirm payload includes:

   * `event_type`
   * `page_url`
   * `session_id`, etc.

---

## Common Errors & Fixes

| Issue             | Fix                                                          |
| ----------------- | ------------------------------------------------------------ |
| Invalid API Key   | Ensure it matches the key received on registration.          |
| Validation Failed | Check required fields: `page_url`, `event_type`, etc.        |
| Domain Mismatch   | Tracked domain must match the registered domain.             |
| No Visitor Data   | Update script to `/api/tracker.js` for full visitor metrics. |

---

## Safety & Compatibility

*  **HTTPS Required**: Accurate IP & country detection.
*  **CORS Protected**: Only registered domains can send data.
*  **Protect Your API Key**: Don't expose it publicly.
*  **Legacy Support**: Older scripts still function (limited metrics).

---

##  Quick Summary

| Step       | Action                                                    |
| ---------- | --------------------------------------------------------- |
| ✅ Register | `POST /api/sites` to get your `api_key` and script        |
| ✅ Embed    | Add `<script>` tag site-wide                              |
| ✅ Track    | Auto-collects page views, clicks, durations, and visitors |
| ✅ Analyze  | Fetch via `GET /api/analytics?api_key=...`                |
| ✅ Upgrade  | Switch to `/api/tracker.js` for new visitor metrics       |

---

##  Upgrade Notice for Existing Users

> If you're using the old `/api/process.js`, it still works.

To enable **visitor insights**:

```html
<script src="https://analytics.essentialnews.ng/api/tracker.js?api_key=xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"></script>
```



---

## 🛠️ Technical Stack

* **Backend**: Laravel, MySQL
*  **Jobs**: Queued background event processing
*  **Storage**: `session_id`, `ip_address`, timestamps
*  **Client Script**: Pure JavaScript, no dependencies
*  **Performance**: Indexing & optimized queries

---

## 🙋 Need Help?

 Email: [webmasterjdd@gmail.com](mailto:webmasterjdd@gmail.com)
 Found a bug? [Open an issue](https://github.com/hardeex/website-tracker-analytics/issues)

> Made with ❤️ using Laravel & JavaScript, focused on **developer happiness** and **simplicity**.

---


