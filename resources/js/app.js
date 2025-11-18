import './bootstrap';
import '../css/app.css';
import AOS from 'aos'
import 'aos/dist/aos.css'

document.addEventListener('DOMContentLoaded', () => {
  AOS.init({
    duration: 800, // lama animasi (ms)
    once: true,    // animasi hanya sekali
  })
})

