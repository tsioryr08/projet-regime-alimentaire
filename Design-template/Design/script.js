// Star rating
function setStars(n) {
  document.querySelectorAll('#stars span').forEach((s, i) => {
    s.classList.toggle('on', i < n);
  });
}

// Range label sync (called inline via oninput, but also wired here for flexibility)
document.addEventListener('DOMContentLoaded', () => {
  const range = document.getElementById('priority-range');
  const label = document.getElementById('range-label');
  if (range && label) {
    range.addEventListener('input', () => { label.textContent = range.value; });
  }
});
