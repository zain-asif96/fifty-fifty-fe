export const redirectionStore = () => {
    const isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
    const isAndroid = /Android/.test(navigator.userAgent);
    const isChrome = /Chrome/.test(navigator.userAgent);
    const isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
    const isFirefox = /Firefox/.test(navigator.userAgent);

    if (isiOS || isSafari) {
        window.location.href =
            "https://apps.apple.com/us/app/uber-request-a-ride/id368677368";
    } else if (isAndroid || isChrome || isFirefox) {
        // Adjust the Android package name and URL
        window.location.href =
            "https://play.google.com/store/apps/details?id=com.ubercab";
    } else {
        // Handle other platforms or provide a generic message
        window.location.href = "https://test.fiftyfifty.io";
    }
};
