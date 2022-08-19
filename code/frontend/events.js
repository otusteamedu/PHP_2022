import fetchApi from './fetch.js';

const emailsHandler = (ev) => {
  ev.preventDefault();
  const button = ev.currentTarget;
  const input = document.querySelector('textarea[name="emails_string"]');
  if (!input.value) {
    return;
  }
  button.disabled = true;
  button.removeEventListener('click', emailsHandler);
  fetchApi(button.name, input.value)
    .then( async (res) => {
      const resDiv = document.querySelector('.res');
      if (res.status === 200) {
        const emails = await res.json();
        if (emails.all.length) {
          resDiv.innerHTML = `<div style='font-weight: 700; margin-bottom: 20px'>Emails found:</div>`;
          resDiv.innerHTML += `<div style='font-weight: 700'>All: ${emails.all.length}</div>`;
          emails.all.forEach((email) => {
            resDiv.innerHTML += `<div style='font-weight: 400'>${email}</div>`;
          });
          resDiv.innerHTML += `<div style='font-weight: 700; margin-top: 20px'>A record exists: ${emails.domain.length}</div>`;
          emails.domain.forEach((email) => {
            resDiv.innerHTML += `<div style='font-weight: 400'>${email}</div>`;
          });
          resDiv.innerHTML += `<div style='font-weight: 700; margin-top: 20px'>MX record exists: ${emails.mx.length}</div>`;
          emails.mx.forEach((email) => {
            resDiv.innerHTML += `<div style='font-weight: 400'>${email}</div>`;
          });
        } else {
          resDiv.innerHTML = `<div style='font-weight: 700'>No emails found</div>`;
        }
      } else {
        resDiv.innerHTML = `<div style='font-weight: 700'>Status: ${res.status}</div><div style='font-weight: 700'>Response: ${res.statusText}</div>`;
        res.headers.forEach((value, title) => {
          resDiv.innerHTML += `<div>${title}: ${value}</div>`;
        });
      }
      button.addEventListener('click', emailsHandler);
      button.disabled = false;
    });
};

const bracketsHandler = (ev) => {
  ev.preventDefault();
  const button = ev.currentTarget;
  const input = document.querySelector('input[name="http"]');
  if (!input.value) {
    return;
  }
  button.removeEventListener('click', bracketsHandler);
  button.disabled = true;
  fetchApi(button.name, input.value)
    .then( async (res) => {
      const resDiv = document.querySelector('.res');
      if (res.status === 200) {
        const text = await res.json();
        resDiv.innerHTML = `<div style='font-weight: 700'>Status: ${200}</div><div style='font-weight: 700'>SessionID: ${text[0]}</div><div style='font-weight: 700'>HostName: ${text[1]}</div>`;
      } else {
        resDiv.innerHTML = `<div style='font-weight: 700'>Status: ${res.status}</div><div style='font-weight: 700'>Response: ${res.statusText}</div>`;
      }

      res.headers.forEach((value, title) => {
        resDiv.innerHTML += `<div>${title}: ${value}</div>`;
      });

      button.addEventListener('click', bracketsHandler);
      button.disabled = false;
    });
};

const changeApiHandler = (ev) => {
  const activeContainer = ev.currentTarget.id;
  const containers = [
    'emailsInput',
    'bracketsInput',
  ];
  containers.forEach((container) => {
    const node = document.querySelector(`.${container}`);
    if (container === activeContainer) {
      node.style.display = 'block';
    } else {
      node.style.display = 'none';
    }
  });
  const resDiv = document.querySelector('.res');
  resDiv.innerHTML = `<div style='font-weight: 700'>${document.querySelector(`.${activeContainer}`).querySelector('h3').textContent}</div>`;
}

const generatorHandler = (ev) => {
  ev.preventDefault();
  const left = '(';
  const right = ')';
  const input = document.querySelector('input[name="http"]');
  input.value = '';
  for (let i = Math.floor(Math.random() * 30 + 1); i >= 0; i--) {
    input.value += Math.round(Math.random()) ? left : right;
  }
  if (input.value.length % 2) {
    input.value = input.value.substring(0, input.value.length - 1);
  }
}

export {bracketsHandler, emailsHandler, changeApiHandler, generatorHandler};
