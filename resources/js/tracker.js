(function() {
    document.addEventListener('DOMContentLoaded', function() {
        let sessionId = localStorage.getItem('tracker_session_id');
        if (!sessionId) {
            sessionId = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
            localStorage.setItem('tracker_session_id', sessionId);
        }

        var tracker = {
            track: function(eventType, data) {
                console.debug('Tracking event:', {
                    eventType,
                    data,
                    page_url: window.location.href,
                    api_key: '{{API_KEY}}',
                    session_id: sessionId,
                    timestamp: new Date().toISOString()
                });
                fetch('{{API_DOMAIN}}/api/track', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        api_key: '{{API_KEY}}',
                        event_type: eventType,
                        page_url: window.location.href,
                        user_agent: navigator.userAgent,
                        session_id: sessionId,
                        ...data
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => console.debug('Track response:', data))
                .catch(error => console.error('Tracking error:', error));
            }
        };

        tracker.track('pageview', {});
        var startTime = Date.now();
        window.addEventListener('beforeunload', function() {
            var duration = Math.round((Date.now() - startTime) / 1000);
            tracker.track('pageview', { session_duration: duration });
        });

        document.addEventListener('click', function(e) {
            var elementId = e.target.id || null;
            tracker.track('click', { element_id: elementId });
        });
    });
})();