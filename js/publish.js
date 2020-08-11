// POST REQUEST
function newFetch(path, data = {}, token = null) {
  var encodedString = '';
  for (var prop in data) {
    if (data.hasOwnProperty(prop)) {
      if (encodedString.length > 0) {
        encodedString += '&';
      }
      encodedString += encodeURIComponent(prop) + '=' + encodeURIComponent(data[prop]);
    }
  }
  let fetchData = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    credentials: 'include',
    body: encodedString,
  };
  if (token) fetchData.headers.Authorization = 'Bearer ' + token;
  return fetch(path, fetchData);
}

// POST REQUEST without encoding
function newFetch2(path, data, token = null) {
  let fetchData = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    credentials: 'include',
    body: JSON.stringify(data),
  };
  if (token) fetchData.headers.Authorization = 'Bearer ' + token;
  return fetch(path, fetchData);
}

// GET REQUEST
function newFetchGet(path, token = null) {
  let fetchData = {
    method: 'GET',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    credentials: 'include',
  };
  if (token) fetchData.headers.Authorization = 'Bearer ' + token;
  return fetch(path, fetchData);
}

function publish(data, nodeBBURL, publishURL, publishPHP, manualButton = null) {
  data.markdown = data.markdown + "\n <b>Click <a href='" + data.url + "'>here</a> to see the full blog post</b>";

  console.log(data);
  if ('token' in localStorage && localStorage.status === '200') {
    // Publish the article to CryptoFR Forum
    newFetch(publishURL, data, localStorage.token)
      .then(res => {
        status = res.status;
        return res;
      })
      .then(res => res.json())
      .then(function (res) {
        console.log('status', status);
        console.log('res', res);

        if (status == '403') {
          // Not published correctly
          status = 'Pending';
        } else {
          status = 'Published'; // OK
        }

        id = data.id;

        data = {};
        data.status = status;
        data.id = id;

        console.log(publishPHP);

        // Set the cryptofrcommment status attribute of the article in the wp database to Published or Pending
        newFetch(publishPHP, data)
          .then(res => res.json())
          .then(function (res) {
            if (res == 'false') {
              console.log('Error during Wordpress Database store endpoint');
              return false;
            }
            if (manualButton) {
              alert('Article has been manually Published to forum');
              location.reload();
            }
          });
      });
  } else {
    status = 'Pending';
    id = data.id;
    data = {};
    data.status = status;
    data.id = id;
    newFetch(publishPHP, data)
      .then(res => res.json())
      .then(function (res) {
        if (res == 'false') {
          console.log('Error during Wordpress Database store endpoint');
          return false;
        }
        if (manualButton) {
          alert('Article has been manually Published to forum');
          location.reload();
        }
      });
  }
}

//
function publishOldArticles(data, nodeBBURL, publishURL, publishPHP) {
  console.log('data', data);

  if ('token' in localStorage && localStorage.status === '200') {
    // Publish all the articles to CryptoFR Forum
    newFetch2(publishURL, data, localStorage.token)
      .then(res => {
        status = res.status;
        return res;
      })
      .then(res => res.json())
      .then(function (res) {
        if (status != '200') {
          // If there was an error publishing the articles in the CryptoFR forum
          alert('Error publishing Old Articles to the Forum. Try Again Later');
          console.log(res);
          return;
        }

        // Set the cryptofrcommment status attribute of all the articles in the wp database to Published
        newFetch2(publishPHP, res.ids)
          .then(res => res.json())
          .then(function (res) {
            console.log(res);
            if (res != 'false') {
              alert('Old Articles has been manually Published to the forum');
              location.reload();
            } else {
              alert('Error updating Wordpress Database');
            }
          });
      });
  } else {
    alert('Error publishing Old Articles to the Forum. Try Again Later');
  }
}
