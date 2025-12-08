import './bootstrap';
import '../css/app.css';
import AOS from 'aos'
import 'aos/dist/aos.css'
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
  AOS.init({
    duration: 800, // lama animasi (ms)
    once: true,    // animasi hanya sekali
    
  })
})

/*
setInterval(()=> {
  fetch('/notif/count')
    .then(r=>r.json())
    .then(d=>{
      const b = document.querySelector('#notif-badge');
      if(b){ b.innerText = d.count; b.style.display = d.count>0 ? 'flex' : 'none'; }
    });

  fetch('/chat-count')
    .then(r=>r.json())
    .then(d=>{
      const b = document.querySelector('#chat-badge');
      if(b){ b.innerText = d.count; b.style.display = d.count>0 ? 'flex' : 'none'; }
    });
}, 3000);
*/
