function sendForm() {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/validate');
  xhr.onload = () => {
    document.querySelector('#result').innerHTML = xhr.response;
  }
  let formData = new FormData(document.forms.brackets_form);
  xhr.send(formData);
}

document.forms.brackets_form.addEventListener('submit', (e) => {
  e.preventDefault();
  sendForm();
});
