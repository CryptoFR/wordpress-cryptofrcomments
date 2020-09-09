// ----- FUNCTIONS

// Data Table init for Comments from nodebb
function setDataTable(table, data) {
  table.innerHTML = '<thead><tr><th class="article-user">User</th><th class="article-comment">Comment</th><th class="article-date">Date</th><th class="article-votes">Votes</th><th class="article-actions">Actions</th><th class="article-children">Children</th><th class="article-expand"></th></tr></thead><tbody></tbody>';
  // console.log('1', data);
  if (data)
    return $(table).DataTable({
      bAutoWidth: false,
      // ajax: '../php/sites.php',
      order: [2, 'desc'],
      aaData: data,
      columns: [
        {
          data: 'user.username',
          className: 'article-user',
        },
        {
          data: 'content',
          className: 'article-comment',
          render: function (data) {
            return singleGifComment(data);
          },
        },
        {
          data: 'timestamp',
          render: function (data) {
            return timeStamptoDate(data);
          },
          className: 'article-date',
        },
        {
          data: 'votes',
          className: 'article-votes',
        },
        {
          data: null,
          defaultContent: '<button class="moderate">Delete</button>',
          className: 'article-actions',
        },
        {
          data: 'children',
          render: function (data) {
            if (data) {
              return data.length;
            } else return 0;
          },
          className: 'article-children',
        },
        {
          className: 'details-control article-expand',
          orderable: false,
          data: 'pid',
          defaultContent: '',
        },
      ],
      select: {
        style: 'os',
        selector: 'td:not(:first-child)',
      },
      createdRow: function (row, data, index) {
        let pidCell = row.querySelector('.details-control');
        let pid = pidCell.innerText;
        pidCell.setAttribute('data-pid', pid);
        pidCell.innerText = '';

        let childrenCell = row.querySelector('.article-children');
        let length = childrenCell.innerText;
        if (length == '0') {
          pidCell.classList.remove('details-control');
        }

        if (data.topic.externalLink) {
          let commentCell = row.querySelector('.article-comment');
          $(commentCell).wrapInner('<a href="' + data.topic.externalLink + '" target="_blank" ></a>');
        }
      },
    });
}

function setDataTableMarkedArticles(table, data) {
  // console.log('2', data);
  if (data)
    return $(table).DataTable({
      bAutoWidth: false,
      // ajax: '../php/sites.php',
      order: [1, 'desc'],
      aaData: data,
      columns: [
        {
          data: 'post_title',
          className: 'article-title',
        },
        {
          data: 'post_date',
          className: 'article-date',
        },
        {
          data: 'cryptofrcomments',
          className: 'article-status',
        },
        {
          data: 'post_title',
          className: 'article-error',
          render: function (data, display, object) {
            if (escapeContent(object.post_content).length <= 8) {
              return 'Post content can not be less than 8 chars';
            } else return '';
          },
        },
        {
          data: 'cryptofrcomments',
          className: 'article-actions',
          render: function (data, display, object) {
            return '<button data-post_content="' + escapeContent(object.post_content) + '" data-post_title="' + object.post_title + '" data-post_author="' + object.post_author + '" data-id="' + object.ID + '" data-guid="' + object.guid + '" data-cid="' + cid + '" class="publish-button">Publish</button>';
          },
        },
      ],
      select: {
        style: 'os',
        selector: 'td:not(:first-child)',
      },
    });
}

function setDataTableConflictedArticles(table, data) {
  console.log('conflicted table', data);
  if (data)
    return $(table).DataTable({
      bAutoWidth: false,
      // ajax: '../php/sites.php',
      order: [1, 'desc'],
      aaData: data,
      columns: [
        {
          data: 'title',
          className: 'article-title',
          render: function (data, display, object) {
            return '<a href="' + object.guid + '" target="_blank">' + data + '</a>';
          },
        },
        {
          data: 'date',
          className: 'article-date',
        },
        {
          data: 'tids',
          className: 'article-actions',
          render: function (data, display, object) {
            let buttons = '';
            for (let tid of data) {
              if (buttons) buttons += '</br>';
              buttons += '<button data-post_tid="' + tid + '" data-post_title="' + object.title + '" data-id="' + object.articleId + '" data-post_author="' + object.author + '" class="conflicted-article-button">Attach ' + tid + '</button>';
              buttons += '&nbsp;<a href="' + nodeBBURL + '/topic/' + tid + '" target="_blank">Forum Topic</a>';
            }
            return buttons;
          },
        },
      ],
      select: {
        style: 'os',
        selector: 'td:not(:first-child)',
      },
    });
}

function escapeContent(content) {
  content = content.replace('\n', '');
  content = content.replace('<!-- wp:paragraph -->', '');
  content = content.replace('<!-- /wp:paragraph -->', '');
  return content;
}

// Create a new JavaScript Date object based on the timestamp
function timeStamptoDate(timeStamp) {
  var date_ob = new Date(timeStamp);
  // adjust 0 before single digit date
  let date = ('0' + date_ob.getDate()).slice(-2);
  // current month
  let month = ('0' + (date_ob.getMonth() + 1)).slice(-2);
  // current year
  let year = date_ob.getFullYear();
  // current hours
  let hours = date_ob.getHours();
  // current minutes
  let minutes = date_ob.getMinutes();
  // current seconds
  let seconds = date_ob.getSeconds();

  // prints date & time in YYYY-MM-DD HH:MM:SS format
  return year + '-' + month + '-' + date + ' ' + hours + ':' + minutes + ':' + seconds;
}

function reIndexOf(reIn, str, startIndex) {
  var re = new RegExp(reIn.source, 'g' + (reIn.ignoreCase ? 'i' : '') + (reIn.multiLine ? 'm' : ''));
  re.lastIndex = startIndex || 0;
  var res = re.exec(str);
  if (!res) return -1;
  return re.lastIndex - res[0].length;
}

// Parse image from comment
function singleGifComment(comment) {
  var converter = new window.showdown.Converter();
  while (comment.indexOf('![') >= 0) {
    let src = comment.substring(comment.indexOf('](') + 2, reIndexOf(/\.(gif|png|jpe?g)\)/gi, comment) + 4);
    let imgTag = "<img class='gif-post' src='" + src + "'>";

    if (comment.substring(comment.indexOf('![]') - 6, comment.indexOf('![]')) != '&gt;  ' && comment.indexOf('![]') > 1) {
      imgTag = imgTag;
    }
    comment = comment.substring(0, comment.indexOf('![')) + ' ' + imgTag + ' ' + comment.substring(reIndexOf(/\.(gif|png|jpe?g)\)/gi, comment) + 5, comment.length);
  }
  comment = converter.makeHtml(comment);
  return comment;
}

// REMOVE ELEMENT NODE FROM DOM
function removeNodes(nodes) {
  var nodeList = nodes && nodes.length !== undefined ? nodes : [nodes];
  var len = nodeList.length;
  if (nodes)
    for (var i = 0; i < len; i++) {
      var node = nodeList[i];
      node.parentNode.removeChild(node);
    }
}

// CREATE THE INNER TABLE AS CHILD FROM THE PARENT COMMENT WHEN EXPAND
function createChild(row, cell) {
  // This is the table we'll convert into a DataTable
  let table = document.createElement('table');
  $(table).addClass('article-table').addClass('display').css('width', '100%');
  let tr = document.createElement('tr');
  let td = document.createElement('td');
  td.setAttribute('colspan', '8');
  tr.append(td);
  td.append(table);

  // Display it the child row
  $(tr).insertAfter($(cell.closest('tr')));

  // Initialise as a DataTable
  let childrenData = data.posts.find(post => post.pid == cell.getAttribute('data-pid')).children;

  var usersTable = setDataTable(table, childrenData);
}

// DESTROY THE CHILD TABLE WHEN CLOSE
function destroyChild(row, cell) {
  // var table = $("table", row.child());
  var table = cell.parentNode.nextSibling.querySelector('table');
  $(table).detach();
  $(table).DataTable().destroy();

  // And then hide the row
  $(cell.parentNode.nextSibling).remove();
}

// SET VALUES TO USER TAB
function setUSerData() {
  document.querySelector('.user-name').innerText = localStorage.username;
  if ('picture' in localStorage) {
    document.querySelector('.user-image').setAttribute('src', localStorage.picture);
    document.querySelector('.user-image').setAttribute('alt', localStorage.username);
    document.querySelector('.user-image').setAttribute('title', localStorage.username);
    removeNodes(document.querySelector('.user-icon'));
  } else {
    document.querySelector('.user-icon').setAttribute('title', localStorage.username);
    document.querySelector('.user-icon').setAttribute('alt', localStorage.username);
    document.querySelector('.user-icon').innerText = localStorage.innerText;
    document.querySelector('.user-icon').style.backgroundColor = localStorage.backgroundColor;
    removeNodes(document.querySelector('.user-image'));
  }
}

// LOGIN CALL WHEN FORM SUBMIT
function login(username, password) {
  return newFetch(nodeBBURL + '/comments/login', {
    username: username,
    password: password,
  })
    .then(res => res.json())
    .then(res => {
      // console.log('LOGIN RES', res);
      if (res.ok) {
        localStorage.clear();
        localStorage.token = res.token;
        localStorage.status = 200;
        localStorage.uid = res.user.uid;
        localStorage.username = res.user.username;
        if (res.user.picture) localStorage.picture = res.user.picture;
        else {
          localStorage.innerText = res.user['icon:text'];
          localStorage.backgroundColor = res.user['icon:bgColor'];
        }
        location.reload();
      } else {
        localStorage.clear();
        loginError("L'identifiant et/ou le mot de passe sont erronés");
        var loginButton = document.querySelector('#login-modal button.login-button');
        loginButton.classList.remove('loading-button');
      }
    });
}

// DISPLAY LOGIN ERROR
function loginError(message) {
  var modal = document.querySelector('#login-modal');
  modal.querySelector('.nodebb-error').innerText = message;
  modal.querySelector('.nodebb-error').classList.add('display');
  setTimeout(function () {
    modal.querySelector('.nodebb-error').innerText = '';
    modal.querySelector('.nodebb-error').classList.remove('display');
  }, 6000);
}

// SOCIAL AUTH
function addSocialAuthListeners(modal) {
  for (let socialLink of modal.querySelectorAll('a[data-link]')) {
    socialLink.addEventListener('click', function (event) {
      event.preventDefault();

      var w = window.open(this.getAttribute('data-link'), this.getAttribute('data-network'), 'menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes');
      var interval = setInterval(function checkSocialAuth() {
        if (w === null || w.closed === true) {
          clearInterval(interval);
        }
      }, 1000);
    });
  }
}

function filterResponse(response, code = 0) {
  let filteredResponse = [];
  for (const res of response) {
    if (res.code == code) filteredResponse.push(res);
  }
  return filteredResponse;
}

function onlyUnique(value, index, self) {
  return self.indexOf(value) === index;
}

function getUniqueBloggers(articles) {
  let uniqueBloggers = [];
  for (let article of articles) {
    uniqueBloggers.push(article.post_author);
  }
  return uniqueBloggers.filter(onlyUnique);
}

async function constructDataForAttachment(oldArticles, bloggerPHP) {
  let dataArray = {};
  dataArray['list'] = [];

  let uniqueBloggers = getUniqueBloggers(oldArticles);

  for (let blogger of uniqueBloggers) {
    await newFetchGet(bloggerPHP + '/' + blogger)
      .then(res => res.json())
      .then(function (res) {
        if (res == 'false') {
          console.log('error on getblogger endpoint');
          return false;
        }

        let filteredByBlogger = oldArticles.filter(obj => {
          return obj.post_author === blogger;
        });

        for (const article of filteredByBlogger) {
          let dateobj = new Date(article.post_date);

          let data = {
            title: article.post_title,
            date: dateobj.toISOString(),
            id: article.ID,
            blogger: res.name,
          };
          dataArray['list'].push(data);
        }
      });
  }
  return dataArray;
}

function joinOldArticlesWithConflicted(oldArticles, conflictedArticles) {
  for (let conflictedArticle of conflictedArticles) {
    let oldArticle = oldArticles.filter(i => [conflictedArticle.articleId].includes(i.ID));
    conflictedArticle.title = oldArticle[0].post_title;
    conflictedArticle.author = oldArticle[0].post_author;
    conflictedArticle.date = oldArticle[0].post_date;
    conflictedArticle.guid = oldArticle[0].guid;
  }
  return conflictedArticles;
}

function groupCommentsByArticleID(auxWpComments) {
  let groupedComments = [];
  for (let comment of auxWpComments) {
    let group = groupedComments.filter(obj => {
      return obj.articleId === comment.articleId;
    });

    if (group.length) group[0].comments.push(comment);
    else {
      let auxgroup = {};
      auxgroup.articleId = comment.articleId;
      auxgroup.comments = [];
      auxgroup.comments.push(comment);
      groupedComments.push(auxgroup);
    }
  }
  return groupedComments;
}

function insertWpCommentChildren(wpComments, auxWpComments, auxParentComment, auxComment, superRecursive) {
  auxParentComment = auxWpComments.filter(obj => {
    return obj.commentId === superRecursive[0].comment_ID;
  });
  if (auxParentComment.length == 0) {
    superRecursive = wpComments.filter(obj => {
      return obj.comment_ID === superRecursive[0].comment_parent;
    });
    return insertWpCommentChildren(wpComments, auxWpComments, auxParentComment, auxComment, superRecursive);
  } else if (auxParentComment[0].commentId != auxComment.parentId) {
    auxWpComments = auxParentComment[0].children;
    superRecursive = wpComments.filter(obj => {
      return obj.comment_ID === auxComment.parentId;
    });
    return insertWpCommentChildren(wpComments, auxWpComments, auxParentComment, auxComment, superRecursive);
  }

  auxParentComment[0].children.push(auxComment);
}

function structureWpComments() {
  let auxWpComments = [];
  for (let comment of wpComments) {
    let auxComment = {};

    auxComment.commentId = comment.comment_ID;
    auxComment.articleId = comment.comment_post_ID;
    auxComment.parentId = comment.comment_parent;
    auxComment.date = comment.comment_date;
    auxComment.user = comment.comment_author;
    auxComment.userEmail = comment.comment_author_email;
    auxComment.content = comment.comment_content;
    auxComment.children = [];

    if (auxComment.parentId > 0) {
      let superRecursive = wpComments.filter(obj => {
        return obj.comment_ID === auxComment.parentId;
      });

      insertWpCommentChildren(wpComments, auxWpComments, null, auxComment, superRecursive);
    } else auxWpComments.push(auxComment);
  }
  return groupCommentsByArticleID(auxWpComments);
}

function setDataTableToEachArticle(articles) {
  // Set a datatable to each articles
  for (const article of articles) {
    let table = document.createElement('table');
    $(table)
      .addClass('article-table')
      .addClass('display')
      .attr('id', 'table-' + article[1].topic.tid)
      .css('width', '100%');

    let div = document.createElement('div');
    $(div)
      .addClass('article-table-container')
      .attr('id', 'div-' + article[1].topic.tid);

    let h2 = document.createElement('h2');
    $(h2).attr('id', 'h2-' + article[1].topic.tid);
    h2.innerText = article[1].topic.title;

    let select = document.createElement('select');
    $(select).attr('id', 'select-' + article[1].topic.tid);
    for (let optCid of optionalCidsCopy) {
      var option = document.createElement('option');
      option.value = optCid.cid;
      option.text = optCid.cid;
      select.add(option);
    }
    $(select)
      .find('option[value="' + article[1].topic.cid + '"]')
      .prop('selected', true);

    let button = document.createElement('button');
    $(button)
      .attr('id', 'button-' + article[1].topic.tid)
      .attr('class', 'change-cid');
    button.innerText = 'Change CategoryID';

    div.append(h2);
    div.append(select);
    div.append(button);
    div.append(table);
    document.querySelector('.comments-tables').append(div);

    setDataTable(table, article[1].posts);
  }
}

// ----- EVENTS

// WHEN TAB IS CHANGED IT CHECKS IF LOGIN STATE HAS CHANGE AND RELOADS THE PAGE
document.addEventListener('visibilitychange', function () {
  newFetchGet(nodeBBURL + '/comments/bycid/' + cid, localStorage.token)
    .then(res => res.json())
    .then(function (res) {
      // console.log(res);
      // Now im logged in
      if (data.error && !res.error) {
        location.reload();
      } // Now Im disconected
      else if (!data.error && res.error) {
        location.reload();
        // Logged in but not authorized
      } else if (data.error && res.error && data.message != res.message) {
        location.reload();
      }

      data = res;
    });
});

// MOVE CID FROM TOPIC
$(document).on('click', '.change-cid', function () {
  let topicID = $(this).attr('id');
  topicID = topicID.substring(7);
  let select = document.querySelector('#select-' + topicID);
  console.log('new cid', select.value);

  let data = {};
  data.tid = topicID;
  data.newCid = select.value;

  newFetch2(nodeBBURL + '/comments/move', data, localStorage.token)
    .then(res => res.json())
    .then(function (res) {
      console.log(res);
      if (!res.ok) {
        console.log('error on move endpoint');
        return false;
      }
      location.reload();
    });
});

// WHEN EXPAND ICON IS CLICKED, CREATES OR DESTROY THE CHILD COMMENTS TABLE
$(document).on('click', '#grid td.details-control', function () {
  var tr = $(this).closest('tr');
  var row = siteTable.row(tr);

  if ($(tr).hasClass('shown')) {
    // This row is already open - close it
    tr.removeClass('shown');
    destroyChild(row, this);
  } else {
    // Open this row
    tr.addClass('shown');
    createChild(row, this); // class is for background colour
  }
});

// WHEN CLICK ON ARTICLE TITLE, IT TOGGLE DISPLAY FOR ITS COMMENTS TABLE
$(document).on('click', '.comments-tables h2', function () {
  let tableContainer = this.closest('.article-table-container');
  let dataTable = tableContainer.querySelector('.dataTables_wrapper');
  $(dataTable).toggle(500);
});

// WHEN CLICK ON DELETE BUTTON, DELETE COMMENT FROM FORUM AFTER A CONFIRM
$(document).on('click', '.comments-tables .moderate', function () {
  if (window.confirm('Do you really want to Delete this comment?')) {
    let tr = this.closest('tr');
    let pidCell = tr.querySelector('.article-expand');
    let pid = pidCell.getAttribute('data-pid');
    newFetch(nodeBBURL + '/comments/delete/' + pid, {}, localStorage.token).then(function () {
      location.reload();
    });
  }
});

// LOGOUT
$(document).on('click', '.logout-box', function () {
  localStorage.clear();
  location.reload();
});

// WHEN LOGIN FORM SUBMIT, SEND POST REQUEST THROUGH FETCH
$(document).on('submit', '#login-form', function (event) {
  event.preventDefault();
  let username = this.querySelector("[name='email']").value;
  let password = this.querySelector("[name='password']").value;
  login(username, password);
});

// PUBLISH SINGLE
$(document).on('click', '.publish-button', function (event) {
  event.preventDefault();

  var button = this;

  newFetchGet(bloggerPHP + '/' + button.getAttribute('data-post_author'))
    .then(res => res.json())
    .then(function (res) {
      if (res == 'false') {
        console.log('error on getblogger endpoint');
        return false;
      }
      data = {
        markdown: button.getAttribute('data-post_content'),
        title: button.getAttribute('data-post_title'),
        cid: button.getAttribute('data-cid'),
        blogger: res.name,
        tags: '',
        id: button.getAttribute('data-id'),
        url: button.getAttribute('data-guid'),
        timestamp: Date.now(),
        uid: '',
        _csrf: '',
      };

      publish(data, nodeBBURL, publishURL, publishPHP, button);
    });
});

// CONFLICTED ARTICLE ATTACHMENT
$(document).on('click', '.conflicted-article-button', function (event) {
  button = this;
  newFetchGet(bloggerPHP + '/' + button.getAttribute('data-post_author'))
    .then(res => res.json())
    .then(function (res) {
      if (res == 'false') {
        console.log('error on getblogger endpoint');
        return false;
      }
      let data = {};
      data.blogger = res.name;

      newFetch2(nodeBBURL + '/attach-single-topic/' + cid + '/' + button.getAttribute('data-post_tid') + '/' + button.getAttribute('data-id'), data, localStorage.token)
        .then(res => res.json())
        .then(function (res) {
          if (res.ok) {
            data = {};
            data.status = 'Published';
            data.id = button.getAttribute('data-id');

            // Set the cryptofrcommment status attribute of the article in the wp database to Published or Pending
            newFetch(publishPHP, data)
              .then(res => res.json())
              .then(function (res) {
                if (res == 'false') {
                  console.log('Error during Wordpress Database store endpoint');
                  return false;
                }
                alert('Manual Attachment is done');
              });
          } else {
            alert('Error');
            console.log(res);
          }
        });
    });
});

// EXPORT COMMENTS
$(document).on('click', '#export-comments', function (event) {
  console.log(wpComments);

  newFetch2(nodeBBURL + '/comments/import', wpComments, localStorage.token)
    .then(res => res.json())
    .then(function (res) {
      console.log(res);
      if (!res.ok) {
        console.log('error on import endpoint');
        return false;
      }
      // location.reload();
    });
});

// ----- MAIN

var data = null;
var siteTable = null;
var status = null;
var articles = {};
wpComments = structureWpComments();
let optionalCidsCopy = optionalCids.map(x => x);
optionalCidsCopy.push({ cid: cid });

console.log('oldArticles', oldArticles);

// CHECK IF YOU ARE AUTHORIZED
if ('token' in localStorage && localStorage.status === '200') {
  // GET COMMENTS FROM CATEGORY AND CATEGORIZE THEM BY ARTICLE/TOPIC
  newFetchGet(nodeBBURL + '/comments/bycid/' + cid, localStorage.token)
    .then(res => {
      status = res.status;
      return res;
    })
    .then(res => res.json())
    .then(function (res) {
      data = res;
      console.log(data);
      setUSerData();

      if (status == '403') {
        // NOT AUTHORIZED
        document.querySelector('.logout-box').style.display = 'block';
        document.querySelector('.error-cryptofr-auth').style.display = 'block';
        document.querySelector('#cryptofr-user').classList.add('in', 'active');
        document.querySelector('.cryptofr-user-tab').style.display = 'block';
        document.querySelector('.cryptofr-user-tab').classList.add('active');
        setUSerData();
        return;
      }

      // -- Display tabs on dashboard menu
      document.querySelector('#cryptofr-comments').classList.add('in', 'active');
      document.querySelector('.cryptofr-comments-tab').style.display = 'block';
      document.querySelector('.cryptofr-comments-tab').classList.add('active');

      document.querySelector('.cryptofr-user-tab').style.display = 'block';
      document.querySelector('.cryptofr-publish-tab').style.display = 'block';
      document.querySelector('.cryptofr-old-articles-tab').style.display = 'block';

      document.querySelector('.logout-box').style.display = 'block';

      // Group comments by articles

      copyArticles = Object.assign({}, articles);
      for (const l of data.posts) {
        if (!articles.hasOwnProperty(l.tid)) {
          articles[l.tid] = {
            topic: l.topic,
            posts: [],
          };
        }
        articles[l.tid].posts.push(l);
      }
      articles = Object.entries(articles);

      siteTable = setDataTable(document.querySelector('#grid'), data.posts);

      setDataTableToEachArticle(articles);

      if (!cid || cid == 0) document.querySelector('.error-cryptofr-cid').style.display = 'block';

      setDataTableMarkedArticles(document.querySelector('#marked-articles-table'), markedArticles);

      // If there are old articles, button to publish all the Old Articles at the same time on the CryptoFR Forum
      if (document.querySelector('#publish-old-articles'))
        document.querySelector('#publish-old-articles').addEventListener('click', async function () {
          let dataArray = {};

          dataArray['posts'] = [];
          dataArray['cid'] = cid;

          // Append to array the Old Articles with its respective blogger info
          for (let article of oldArticles) {
            await newFetchGet(bloggerPHP + '/' + article.post_author)
              .then(res => res.json())
              .then(function (res) {
                if (res == 'false') {
                  console.log('error on getblogger endpoint');
                  return false;
                }

                let data = {
                  markdown: escapeContent(article.post_content),
                  title: article.post_title,
                  cid: cid,
                  blogger: res.name,
                  tags: '',
                  id: article.ID,
                  url: article.guid,
                  timestamp: Date.now(),
                  uid: '',
                  _csrf: '',
                };
                dataArray['posts'].push(data);
              });
          }
          publishOldArticles(dataArray, nodeBBURL, publishURLArray, publishPHPArray);
        });

      // If there are old articles, button to publish all the Old Articles at the same time on the CryptoFR Forum
      if (document.querySelector('#attach-old-articles'))
        document.querySelector('#attach-old-articles').addEventListener('click', async function () {
          dataArray = await constructDataForAttachment(oldArticles, bloggerPHP);
          console.log('dataArray', dataArray);
          console.log('attachmentURL', attachmentURL);
          console.log('cid', cid);
          status = null;
          newFetch2(attachmentURL + '/' + cid, dataArray, localStorage.token)
            .then(res => {
              status = res.status;
              return res;
            })
            .then(res => res.json())
            .then(function (res) {
              // console.log('status', status);
              console.log('res attach', res);

              attachStatus = 'Pending';
              message = res.message;
              if (status == 200 && message == 'Topics attached') {
                attachStatus = 'Attached';
              }

              let attachmentData = {};
              attachmentData.status = status;
              attachmentData.attachment = attachStatus;
              attachmentData.attachedArticles = filterResponse(res.response);
              attachmentData.conflictedArticles = filterResponse(res.response, 1);
              attachmentData.corruptedArticles = filterResponse(res.response, 2);

              attachmentData.conflictedArticles = joinOldArticlesWithConflicted(oldArticles, attachmentData.conflictedArticles);

              newFetch2(attachmentPHP, attachmentData)
                .then(res => {
                  status = res.status;
                  return res;
                })
                .then(res => res.json())
                .then(function (res) {
                  if (attachmentData.conflictedArticles.length) setDataTableConflictedArticles(document.querySelector('#conflicted-articles-table'), attachmentData.conflictedArticles);

                  // location.reload();
                });
            });
        });

      //-- OPTIONAL CIDS
      for (let optcid of optionalCids) {
        newFetchGet(nodeBBURL + '/comments/bycid/' + optcid.cid, localStorage.token)
          .then(res => {
            status = res.status;
            return res;
          })
          .then(res => res.json())
          .then(function (res) {
            data = res;

            if (status == '403') {
              // NOT AUTHORIZED
              document.querySelector('.error-cryptofr-auth').style.display = 'block';
              return;
            }

            // Group comments by articles
            for (const l of data.posts) {
              if (!copyArticles.hasOwnProperty(l.tid)) {
                copyArticles[l.tid] = {
                  topic: l.topic,
                  posts: [],
                };
              }
              copyArticles[l.tid].posts.push(l);
            }
            copyArticles = Object.entries(copyArticles);

            // siteTable = setDataTable(document.querySelector('#grid'), data.posts);

            // Set a datatable to each article
            setDataTableToEachArticle(copyArticles);
          });
      }
    });
} else {
  // NOT CONNECTED
  document.querySelector('#cryptofr-login').classList.add('in', 'active');
  document.querySelector('.cryptofr-login-tab').style.display = 'block';
  document.querySelector('.cryptofr-login-tab').classList.add('active');
  addSocialAuthListeners(document.querySelector('#login-modal'));
}

console.log('optionalCids', optionalCids);
