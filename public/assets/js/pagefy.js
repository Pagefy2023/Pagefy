
const bar = document.getElementById('bar');
const nav = document.getElementById('navbar');
const close = document.getElementById('close');

bar.addEventListener('click', function() {
    nav.classList.add('active');
    return false;
  });

  close.addEventListener('click', function() {
    nav.classList.remove('active');
    // return false;
  });


//   Affichage About et ContentChapter


document.addEventListener("DOMContentLoaded", function () {
  const resumeLink = document.querySelector("#resume-link");
  const chapitresLink = document.querySelector("#chapitres-link");
  const aboutSection = document.querySelector("#about");
  const chapitresSection = document.querySelector("#contentChapter");

  resumeLink.addEventListener("click", function (e) {
    e.preventDefault();
    aboutSection.style.display = "block";
    chapitresSection.style.display = "none";
  });

  chapitresLink.addEventListener("click", function (e) {
    e.preventDefault();
    chapitresSection.style.display = "block";
    aboutSection.style.display = "none";
  });
});

