function sendForm() {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/validate');
  xhr.onload = () => {
    let validateInfo = document.querySelector('#result .validate-info');
    let serverData = document.querySelector('#result .server-data');

    if (validateInfo) {
      validateInfo.innerHTML = xhr.response.message ?? '- нет данных -';
      validateInfo.classList.remove('alert-info', 'alert-danger', 'alert-success');
      if (xhr.response.status) {
        validateInfo.classList.add('alert-' + xhr.response.status);
      } else {
        validateInfo.classList.add('alert-info');
      }
    }

    if (serverData) {
      let date = serverData.querySelector('.date');
      let hostName = serverData.querySelector('.host-name');
      let sessionId = serverData.querySelector('.session-id');

      if (date) {
        date.innerHTML = xhr.response.date ?? '- нет данных -';
      }

      if (hostName) {
        hostName.innerHTML = xhr.response.hostName ?? '- нет данных -';
      }

      if (sessionId) {
        sessionId.innerHTML = xhr.response.sessionId ?? '- нет данных -';
      }
    }
  }
  xhr.responseType = 'json';
  let formData = new FormData(document.forms.brackets_form);
  xhr.send(formData);
}

document.forms.brackets_form.addEventListener('submit', (e) => {
  e.preventDefault();
  sendForm();
});
