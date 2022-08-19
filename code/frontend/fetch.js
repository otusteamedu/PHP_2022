const fetchApi = async (route, string) =>
  await fetch(
    'http://mysite.local/',
    {
      method: 'POST',
      body: JSON.stringify({route, string,}),
    });
export default fetchApi;
