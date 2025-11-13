// public/js/script.js
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('formAvaliacao');
  form.addEventListener('submit', function(e){
    // Verifica se todas as perguntas possuem respostas
    const perguntas = document.querySelectorAll('.pergunta');
    for (let p of perguntas) {
      const pid = p.getAttribute('data-pergunta-id');
      const checked = p.querySelector('input[type="radio"]:checked');
      if (!checked) {
        e.preventDefault();
        alert('Por favor responda todas as perguntas antes de enviar.');
        // rolar até a pergunta faltante
        p.scrollIntoView({behavior: 'smooth', block: 'center'});
        return false;
      }
    }

    // opcional: confirmar envio
    //if (!confirm('Confirma o envio da avaliação (anônima)?')) {
    //  e.preventDefault();
    //  return false;
    //}
    return true;
  });
});
