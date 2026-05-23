document.querySelectorAll('.annonces').forEach(img => {

  const wrapper = document.createElement('div');
  wrapper.className = 'img-wrapper skeleton';

  img.decoding = 'async';
  img.loading = 'lazy';
  img.setAttribute('fetchpriority', 'low');
 
  const parent = img.parentNode;
  parent.replaceChild(wrapper, img);
  wrapper.appendChild(img);

  img.addEventListener('load', () => {
    wrapper.classList.remove('skeleton');
    img.classList.add('loaded');
  });

  if (img.complete) {
    wrapper.classList.remove('skeleton');
    img.classList.add('loaded');
  }
});



const retour = document.getElementById("back");
    
if (retour) {
    retour.addEventListener("click", () => {
        if (document.referrer === "") {
            window.location.href = "/";
        } else {
            window.history.back();
        }

    });
}



