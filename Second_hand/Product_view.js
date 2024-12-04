function showFullImage() {
  var imgSrc = document.getElementById("bigImg").src;
  document.getElementById("modalImg").src = imgSrc;
  document.getElementById("imageModal").classList.remove("hidden");
}
function hideFullImage() {
  document.getElementById("imageModal").classList.add("hidden");
}


function toggleImagePreview() {
  const imgElement = document.getElementById("bigImg");
  const isPreview = imgElement.classList.contains("preview-mode");

  if (isPreview) {
    // Exit preview mode
    imgElement.classList.remove("preview-mode");
    imgElement.style.position = "";
    imgElement.style.width = "300px";
    imgElement.style.height = "300px";
    imgElement.style.top = "";
    imgElement.style.left = "";
    imgElement.style.transform = "";
    imgElement.style.zIndex = "";
    imgElement.style.objectFit = "cover";
    imgElement.style.backgroundColor = "";
    document.body.style.overflow = ""; // Restore body scroll
  } else {
    // Enter preview mode
    imgElement.classList.add("preview-mode");
    imgElement.style.position = "fixed";
    imgElement.style.width = "80%";
    imgElement.style.height = "80%";
    imgElement.style.top = "50%";
    imgElement.style.left = "50%";
    imgElement.style.transform = "translate(-50%, -50%)";
    imgElement.style.zIndex = "1000";
    imgElement.style.objectFit = "contain";
    imgElement.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
    document.body.style.overflow = "hidden"; // Prevent body scroll in preview mode
  }
}
