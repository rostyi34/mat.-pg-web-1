// public/js/script.js
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('formAvaliacao');
  form.addEventListener('submit', function(e){
   
    const perguntas = document.querySelectorAll('.pergunta');
    for (let p of perguntas) {
      const pid = p.getAttribute('data-pergunta-id');
      const checked = p.querySelector('input[type="radio"]:checked');
      if (!checked) {
        e.preventDefault();
        alert('Por favor responda todas as perguntas antes de enviar.');
        
        p.scrollIntoView({behavior: 'smooth', block: 'center'});
        return false;
      }
    }

 
    return true;
  });
});