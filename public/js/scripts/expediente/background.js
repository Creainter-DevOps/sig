function logURL(requestDetails) {
  console.log("Cargando: " + requestDetails.url);
}

browser.webRequest.onBeforeRequest.addListener(
  logURL,
  {urls: ["<all_urls>"]}
);
