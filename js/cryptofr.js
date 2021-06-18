// ----- MAIN

let paginationCount = 100;
var data = null;
var siteTable = null;
var status = null;
var articles = {};
var copyArticle = {};
var topicsByComents = [];
var commentsByTopicsAuthorized = [];
wpComments = structureWpComments();
let optionalCidsCopy = optionalCids.map((x) => x);
var contadorGlobal = 0;

optionalCidsCopy.push({ cid: cid });
console.log('optionalCidsCopy', optionalCidsCopy);
// ----- FUNCTIONS

function sleep(ms) {
  return new Promise((resolve) => {
    setTimeout(resolve, ms);
  });
}

// Data Table init for Comments from nodebb
function setDataTable(table, data) {
  table.innerHTML = '<thead><tr><th class="article-user">User</th><th class="article-comment">Comment</th><th class="article-date">Date</th><th class="article-votes">Votes</th><th class="article-actions">Actions</th><th class="article-children">Children</th><th class="article-expand"></th></tr></thead><tbody></tbody>';
  console.log('entro en  setDataTable', data);
  //if (data)
  return $(table).DataTable({
    bAutoWidth: false,
    // ajax: '../php/sites.php',
    order: [2, 'desc'],
    aaData: data,
    columns: [
      {
        data: 'username',
        className: 'article-user',
        render: function (data, display, object) {
          if (data === '[[global:guest]]') return object.handle;
          return data;
        },
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

      // if (data.topic.externalLink) {
      //   let commentCell = row.querySelector('.article-comment');
      //   $(commentCell).wrapInner('<a href="' + data.topic.externalLink + '" target="_blank" ></a>');
      // }
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
  let childrenData = data.posts.find((post) => post.pid == cell.getAttribute('data-pid')).children;

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
    .then((res) => res.json())
    .then((res) => {
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
        localStorage.date = new Date();
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
      .then((res) => res.json())
      .then(function (res) {
        if (res == 'false') {
          console.log('error on getblogger endpoint');
          return false;
        }

        let filteredByBlogger = oldArticles.filter((obj) => {
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
    let oldArticle = oldArticles.filter((i) => [conflictedArticle.articleId].includes(i.ID));
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
    let group = groupedComments.filter((obj) => {
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
  auxParentComment = auxWpComments.filter((obj) => {
    return obj.commentId === superRecursive[0].comment_ID;
  });
  if (auxParentComment.length == 0) {
    superRecursive = wpComments.filter((obj) => {
      return obj.comment_ID === superRecursive[0].comment_parent;
    });
    return insertWpCommentChildren(wpComments, auxWpComments, auxParentComment, auxComment, superRecursive);
  } else if (auxParentComment[0].commentId != auxComment.parentId) {
    auxWpComments = auxParentComment[0].children;
    superRecursive = wpComments.filter((obj) => {
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
      let superRecursive = wpComments.filter((obj) => {
        return obj.comment_ID === auxComment.parentId;
      });

      insertWpCommentChildren(wpComments, auxWpComments, null, auxComment, superRecursive);
    } else auxWpComments.push(auxComment);
  }
  return groupCommentsByArticleID(auxWpComments);
}

function setDataTableToEachArticle(articles) {
  // Set a datatable to each articles
  //let article_data= articles;
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
    if (document.querySelector('.comments-tables')) document.querySelector('.comments-tables').append(div);
  }
}

function paginateExportedComments(wpComments) {
  console.log('wpComments', wpComments);
  let paginatedComments = [];
  let totalCount = 0;
  for (let parentArticle of wpComments) {
    let articleId = parentArticle.articleId;
    let count = 0;
    for (let comment of parentArticle.comments) {
      if (count % paginationCount === 0) paginatedComments.push([{ articleId: articleId, comments: [] }]);
      paginatedComments[paginatedComments.length - 1][0].comments.push(comment);
      count++;
      totalCount++;
    }
  }
  return [paginatedComments, totalCount];
}

function displayTabsOnDashboard() {
  // -- Display tabs on dashboard menu
  document.querySelector('.cryptofrcomments-tabs').style.display = 'inline-block';
  document.querySelector('.tab-content').style.display = 'inline-block';
  document.querySelector('#cryptofr-moderation').classList.add('in', 'active');
  document.querySelector('.cryptofr-moderation-tab').classList.add('active');
  document.querySelector('.cryptofr-comments-tab').style.display = 'block';
  document.querySelector('.dashboard-header-icon').style.display = 'block';
  document.querySelector('.cryptofr-user-tab').style.display = 'block';
  document.querySelector('.cryptofr-publish-tab').style.display = 'block';
  document.querySelector('.logout-box').style.display = 'block';
}

function hideTabsOnDashboard() {
  document.querySelector('#cryptofr-login').classList.add('in', 'active');
  document.querySelector('.cryptofr-login-tab').style.display = 'block';
  document.querySelector('.cryptofr-login-tab').classList.add('active');
}

function groupCommentsByArticle() {
  copyArticles = Object.assign({}, articles);

  for (const l of data.posts) {
    //console.log(data.posts);
    if (!articles.hasOwnProperty(l.tid)) {
      articles[l.tid] = {
        topic: { tid: l.tid, title: l.title, cid: l.cid },
        posts: [],
      };
    }
    articles[l.tid].posts.push(l);
  }

  console.log(articles);
  return Object.entries(articles);
}

function publishOldArticlesButton() {
  if (document.querySelector('#publish-old-articles'))
    document.querySelector('#publish-old-articles').addEventListener('click', async function () {
      let dataArray = {};

      dataArray['posts'] = [];
      dataArray['cid'] = cid;

      // Append to array the Old Articles with its respective blogger info
      for (let article of oldArticles) {
        await newFetchGet(bloggerPHP + '/' + article.post_author)
          .then((res) => res.json())
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
}

function attachOldArticleButton() {
  if (document.querySelector('#attach-old-articles'))
    document.querySelector('#attach-old-articles').addEventListener('click', async function () {
      dataArray = await constructDataForAttachment(oldArticles, bloggerPHP);
      console.log('dataArray', dataArray);
      console.log('attachmentURL', attachmentURL);
      console.log('cid', cid);
      status = null;
      newFetch2(attachmentURL + '/' + cid, dataArray, localStorage.token)
        .then((res) => {
          status = res.status;
          return res;
        })
        .then((res) => res.json())
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
          console.log(res.response);
          attachmentData.attachedArticles = filterResponse(res.response);
          attachmentData.conflictedArticles = filterResponse(res.response, 1);
          attachmentData.corruptedArticles = filterResponse(res.response, 2);

          attachmentData.conflictedArticles = joinOldArticlesWithConflicted(oldArticles, attachmentData.conflictedArticles);

          newFetch2(attachmentPHP, attachmentData)
            .then((res) => {
              status = res.status;
              return res;
            })
            .then((res) => res.json())
            .then(function (res) {
              if (attachmentData.conflictedArticles.length) setDataTableConflictedArticles(document.querySelector('#conflicted-articles-table'), attachmentData.conflictedArticles);

              // location.reload();
            });
        });
    });
}

function getCommentsByOptionalCid() {
  let article;
  for (let optcid of optionalCidsCopy) {
    newFetchGet(nodeBBURL + '/comments/bycid/' + optcid.cid, localStorage.token)
      .then((res) => {
        status = res.status;
        return res;
      })
      .then((res) => res.json())
      .then(function (res) {
        data = res;
        //console.log('data cid', data);
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
        article = copyArticles;

        // siteTable = setDataTable(document.querySelector('#grid'), data.posts);

        // Set a datatable to each article
        //console.log(copyArticles);
        //setDataTableToEachArticle(copyArticles);
      });
  }
  //setDataTableModeration(document.querySelector('#table_moderation') , articles);
  //setDataTableArticle(document.querySelector('#articles'), articles);
}

//function used to handle the data that reaches the Comments datatable
function manageDataModeration(dataSet) {
  let response = [];
  for (let i = 0; i < dataSet.length; i++) {
    let count = dataSet[i][1].posts.length;
    dataSet[i][1].topic.count_comments = count;
    let posts = [];
    posts.push(dataSet[i][1].posts);
    dataSet[i][1].topic.posts = posts;
    response.push(dataSet[i][1].topic);
  }
  return response;
}

function manageDataArticles(dataSet) {
  let response = [];
  for (let i = 0; i < dataSet.length; i++) {
    let count = dataSet[i].posts.length;
    dataSet[i].count_comments = count;
    let posts = [];
    posts.push(dataSet[i][1].posts);
    dataSet[i][1].topic.posts = posts;
    response.push(dataSet[i][1].topic);
  }
  return response;
}

function setDataTableModeration(table, dataSet) {
  let textPending = document.createTextNode(dataSet.length);
  document.querySelector('#modEntries').appendChild(textPending);
  table.innerHTML = '<thead style="display:none"></thead><tbody></tbody>';

  let response = manageDataModeration(dataSet);
  if (dataSet) {
    let tables = $(table).DataTable({
      data: response,
      columns: [{ data: 'title' }, { defaultContent: "<button class='buttonComment glyphicon glyphicon-new-window' data-toggle='modal' data-target='#ModalModeration'></button>" }],
      bDestroy: true,
    });

    //on click in arrow of row
  $('#table_moderation tbody').on('click', 'button', function () {
    let data = tables.row($(this).parents('tr')).data();
    let title = document.querySelector('#ModalModerationTitle');
    title.innerHTML = data.title;

    pagination.querySet = data.posts;
    var dataModal = paginationModal(pagination);

    buildModalModeration(dataModal.pageList);

    if (pagination.currentPage === 1) pageButton(pagination);

    $('.pagination-button').on('click', function () {
      $('#ModalModContent').empty();
      var pagination = {
        querySet: data.posts,
        pageList: new Array(),
        currentPage: pagemodal,
        numberPerPage: 10,
        numberOfPage: 0,
      };
      pagination.currentPage = $(this).val();
      let pageActive = $(this);
      pageActive.addClass('pagination-button-active');
      var dataModal = paginationModal(pagination);

      buildModalModeration(dataModal.pageList);
    });

    $('.buttonsnextprev').on('click', function () {
      $('#ModalModContent').empty();
      var pagination = {
        querySet: data.posts,
        pageList: new Array(),
        currentPage: pagemodal,
        numberPerPage: 10,
        numberOfPage: 0,
      };
      let pageActive = $(this);
      pageActive.addClass('pagination-button-active');
      var dataModal = paginationModal(pagination);
      buildModalModeration(dataModal.pageList);
    });
  });

  return tables;
  }
}

//variable used for pagination of the modal in
//comments datatable
var pagination = {
  querySet: new Array(),
  pageList: new Array(),
  currentPage: 1,
  numberPerPage: 10,
  numberOfPage: 0,
};
//variable used as current page of the modal in
//comments datatable
var pagemodal = 1;

var dataAux = [
  {
    title: 'manage bitcoin',
    count: '116',
    comments: [
      {
        content: 'bla bla bla',
        username: 'crytpoUser',
      },
      {
        content: 'le soux jeux ',
        username: 'Nicola',
      },
    ],
  },
  {
    title: 'Blockchain bitcoin',
    count: '81',
    comments: [
      {
        content: 'preux je t aime',
        username: 'cry ser',
      },
      {
        content: 'le soux jeux ',
        username: 'Nicola Ams',
      },
    ],
  },
  {
    title: 'Etherium',
    count: '52',
    comments: [
      {
        content: 'etia jex aime',
        username: 'c ser',
      },
      {
        content: 'le soux foi ',
        username: 'Nicola Amsterdam',
      },
    ],
  },
];

function countChar(comment) {
  countLength = comment.length;
  return countLength;
}

function cutComment(comment) {
  shortComment = '';
  longComment = '';
  for (let i = 0; i < comment.length; i++) {
    // check if character has been seen before
    if (i < 1000) {
      // increase its count by 1
      shortComment = shortComment + comment[i];
    } else {
      // add it to the object with a count of 1
      longComment = longComment + comment[i];
    }
  }
  let result = [shortComment, longComment];
  return result;
}

//Pagination of the Modal in Comments Datatable
function paginationModal(pagination1) {
  var begin = (pagination1.currentPage - 1) * pagination1.numberPerPage;
  var end = begin + pagination1.numberPerPage;
  let pageList1 = pagination1.querySet;
  pagination.pageList = pageList1.slice(begin, end);
  pagination.numberOfPage = Math.ceil(pagination1.querySet.length / pagination1.numberPerPage);
  return {
    pageList: pagination.pageList,
    numberOfPage: pagination.numberOfPage,
  };
}

//Build Modal in Datatable Comments
const buildModal = (data) => {
  let iteration = data;
  for (let k = 0; k < iteration.length; k++) {
    if(iteration[k].deleted === 0){
      if (typeof iteration[k].parent == 'undefined'){
      let cont = document.getElementById('ModalCommentContent');
      let userDataComment = document.createElement('div');
      userDataComment.setAttribute('class', 'section-complete');
      //Create the picture of user
      let userImg = document.createElement('img');
      userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
      userImg.setAttribute('class', 'user-picture');
      userImg.setAttribute('alt', 'This is an user perfil picture');
      userDataComment.appendChild(userImg);
      //Create the name of user
      let userName = document.createElement('label');
      let textUser = document.createTextNode(iteration[k].user['username']);
      userName.setAttribute('class', 'name-user-m');
      userName.setAttribute('id', iteration[k].pid);
      userName.appendChild(textUser);
      userDataComment.appendChild(userName);
      //Create the comment of the user
      let commentUser = document.createElement('p');
      let texComment = document.createTextNode(iteration[k].content);
      commentUser.appendChild(texComment);
      commentUser.setAttribute('class', 'comment-user');
      userDataComment.appendChild(commentUser);
      //Create the buttons
      let buttonReadMore = document.createElement('input');
      buttonReadMore.setAttribute('class', 'btn-readoff');
      if (countChar(iteration[k].content) > 1000) {
        // let commentEdited  = cutComment(iteration[k].content);
        // texComment = document.createTextNode(commentEdited[0]);
        buttonReadMore.setAttribute('class', 'btn-readon');
        buttonReadMore.value = 'Read More';
        buttonReadMore.setAttribute('onclick', 'clickReadMore(this)');
      }
      userDataComment.appendChild(buttonReadMore);
      //button view
      let button2 = document.createElement('button');
      button2.setAttribute('onclick', 'clickButtonView(this)');
      button2.setAttribute('class', 'buttonview');
      userDataComment.appendChild(button2);
      // button trash
      let button1 = document.createElement('button');
      button1.setAttribute('class', 'buttonTrash');
      button1.setAttribute('onclick', 'clickButtonView(this)');
      userDataComment.appendChild(button1);
      //button warning
      let button3 = document.createElement('button');
      button3.setAttribute('onclick', 'clickButtonView(this)');
      button3.setAttribute('class', 'buttonWarning');
      userDataComment.appendChild(button3);
      //Create vertical separator
      let verticalSeparator = document.createElement('div');
      verticalSeparator.setAttribute('class', 'vertical-line');
      //Create the separator
      let separator = document.createElement('div');
      separator.setAttribute('class', 'separator-m');
      cont.appendChild(userDataComment);
      cont.appendChild(verticalSeparator);

      buildCommentsChildren2(iteration, iteration[k].pid);
      cont.appendChild(separator);
      }
    }
  }
  buildCommentsChildren2(iteration);
};

//Build Child Comments of Comments in Comments Datatable
const buildCommentsChildren2 = (iteration, pid) =>{

  for (let k = 0; k < iteration.length; k++) {
    if(iteration[k].deleted === 0){
      if ((typeof iteration[k].toPid != 'undefined') && (iteration[k].toPid == pid)){

      let cont = document.getElementById('ModalCommentContent');
      let userDataComment = document.createElement('div');
      userDataComment.setAttribute('class', 'section-complete-child');
      //create line to vertical line
      let lineChild = document.createElement('div');
      lineChild.setAttribute('class', 'line-child');
      userDataComment.appendChild(lineChild);
      //Create the picture of user
      let userImg = document.createElement('img');
      userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
      userImg.setAttribute('class', 'user-picture-child');
      userImg.setAttribute('alt', 'This is an user perfil picture');
      userDataComment.appendChild(userImg);
      //Create the name of user
      let userName = document.createElement('label');
      let textUser = document.createTextNode(iteration[k].user['username']);
      userName.setAttribute('class', 'name-user-m');
      userName.setAttribute('id', iteration.pid);
      userName.appendChild(textUser);
      userDataComment.appendChild(userName);
      //Create the comment of the user
      let commentUser = document.createElement('p');
      let texComment = document.createTextNode(iteration[k].content);
      commentUser.appendChild(texComment);
      commentUser.setAttribute('class', 'comment-user-child');
      userDataComment.appendChild(commentUser);
      //Create the buttons
      let buttonReadMore = document.createElement('input');
      buttonReadMore.setAttribute('class', 'btn-readoff');
      if (countChar(iteration[k].content) > 1000) {
        // let commentEdited  = cutComment(iteration[k].content);
        // texComment = document.createTextNode(commentEdited[0]);
        buttonReadMore.setAttribute('class', 'btn-readon');
        buttonReadMore.value = 'Read More';
        buttonReadMore.setAttribute('onclick', 'clickReadMore(this)');
      }
      userDataComment.appendChild(buttonReadMore);
      //button view
      let button2 = document.createElement('button');
      button2.setAttribute('onclick', 'clickButtonView(this)');
      button2.setAttribute('class', 'buttonview');
      userDataComment.appendChild(button2);
      // button trash
      let button1 = document.createElement('button');
      button1.setAttribute('class', 'buttonTrash');
      button1.setAttribute('onclick', 'clickButtonView(this)');
      userDataComment.appendChild(button1);
      //button warning
      let button3 = document.createElement('button');
      button3.setAttribute('onclick', 'clickButtonView(this)');
      button3.setAttribute('class', 'buttonWarning');
      userDataComment.appendChild(button3);
      //Create the separator
      let separator = document.createElement('div');
      separator.setAttribute('class', 'separator-m');
      //userDataComment.appendChild(separator);
      cont.appendChild(userDataComment);
      //cont.appendChild(separator);
      }
    }
  }
}


const buildModalModeration = (data) => {
  console.log("buildModalModeration", data);

  let iteration = data[0];
  for (let k = 0; k < iteration.length; k++) {
    let cont = document.getElementById('ModalModContent');
    let userDataComment = document.createElement('div');
    userDataComment.setAttribute('class', 'section-complete');
    //Create the picture of user
    let userImg = document.createElement('img');
    userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
    userImg.setAttribute('class', 'user-picture');
    userImg.setAttribute('alt', 'This is an user perfil picture');
    userDataComment.appendChild(userImg);
    //Create the name of user
    let userName = document.createElement('label');
    let textUser = document.createTextNode(iteration[k].username);
    userName.setAttribute('class', 'name-user-m');
    userName.setAttribute('id', iteration[k].pid);
    userName.appendChild(textUser);
    userDataComment.appendChild(userName);
    //Create the comment of the user
    let commentUser = document.createElement('p');
    let texComment = document.createTextNode(iteration[k].content);
    commentUser.appendChild(texComment);
    commentUser.setAttribute('class', 'comment-user');
    userDataComment.appendChild(commentUser);
    //Create the buttons
    let buttonReadMore = document.createElement('input');
    buttonReadMore.setAttribute('class', 'btn-readoff');
    if (countChar(iteration[k].content) > 1000) {
      // let commentEdited  = cutComment(iteration[k].content);
      // texComment = document.createTextNode(commentEdited[0]);
      buttonReadMore.setAttribute('class', 'btn-readon');
      buttonReadMore.value = 'Read More';
      buttonReadMore.setAttribute('onclick', 'clickReadMore(this)');
    }
    userDataComment.appendChild(buttonReadMore);
    //button view
    let button2 = document.createElement('button');
    button2.setAttribute('onclick', 'clickButtonView(this)');
    button2.setAttribute('class', 'buttonViewOrange');
    userDataComment.appendChild(button2);
    // button trash
    let button1 = document.createElement('button');
    button1.setAttribute('class', 'buttonTrash');
    button1.setAttribute('onclick', 'clickButtonView(this)');
    userDataComment.appendChild(button1);
    //button warning
    let button3 = document.createElement('button');
    button3.setAttribute('onclick', 'clickButtonView(this)');
    button3.setAttribute('class', 'buttonWarning');
    userDataComment.appendChild(button3);
    //Create the separator
    let separator = document.createElement('div');
    separator.setAttribute('class', 'separator-m');
    //userDataComment.appendChild(separator);
    cont.appendChild(userDataComment);
    cont.appendChild(separator);
    }
};
//button > in modal - comments dataTable
function nextPage() {
  if (pagemodal < pagination.numberOfPage) {
    var wrapper = document.getElementById('wrapper');
    wrapper.innerHTML = '';
    wrapper.innerHTML += `<button value=${pagemodal} class='pagination-button' >${pagemodal}</button>`;
    wrapper.innerHTML += `<button value=${pagemodal + 1} id='buttonnext' class='pagination-button' >${pagemodal + 1}</button>`;

    return pagemodal++;
  }
}
//button < in modal - comments dataTable
function previousPage() {
  if (pagemodal > 1) {
    var wrapper = document.getElementById('wrapper');
    wrapper.innerHTML = '';
    wrapper.innerHTML += `<button value=${pagemodal - 1} class='pagination-button' >${pagemodal - 1}</button>`;
    wrapper.innerHTML += `<button value=${pagemodal} id='buttonnext' class='pagination-button' >${pagemodal}</button>`;

    return pagemodal--;
  }
}

//function used for pagination of the modal in
//comments datatable
const pageButton = (currentPage) => {
  let current = currentPage.currentPage;
  var wrapper = document.getElementById('wrapper');
  wrapper.innerHTML = '';
  wrapper.innerHTML += `<button value=${current} class='pagination-button' >${current}</button>`;

  if (currentPage.numberOfPage > 1) {
    wrapper.innerHTML += `<button value=${current + 1} id='buttonnext' class='pagination-button' >${current + 1}</button>`;

    // let buttonnext = document.getElementById('buttonnext');
    // buttonnext.addEventListener('click', function() {
    //     current = $(this).val();
    //     console.log(current);
    // });
  }
};

// Menu Synchronization tab Pending  Syncs
const fillPostPending = () => {
  let posts = dataAux.length;

  //This for will fill the post window.
  for (let k = 0; k < posts; k++) {
    let cont = document.getElementById('posts-container');
    let userDataComment = document.createElement('div');
    userDataComment.setAttribute('class', 'each-post');

    //Create the name of the post
    let postName = document.createElement('label');
    let postText = document.createTextNode(dataAux[k].title);
    postName.setAttribute('class', 'post-name');
    //The onclick function is for open the comments windows and fill it with the content of the comment
    postName.setAttribute('onclick', 'buildCommentsSync(this)');
    postName.appendChild(postText);
    userDataComment.appendChild(postName);

    //Create the buttons

    //EditButton
    let button1 = document.createElement('button');
    button1.setAttribute('class', 'button-sync1');
    userDataComment.appendChild(button1);
    //SyncButton
    let button2 = document.createElement('button');
    button2.setAttribute('class', 'button-sync2');
    userDataComment.appendChild(button2);
    cont.appendChild(userDataComment);
  }
};

//This function is a onclick function, is excuted when we click on a post name
// fill the Post-windows
const buildCommentsSync = (arr) => {
  //Here just we have the name of the post 'arr', with the following loop, we are gonna get the complete object associated with the post
  let postNameShowed = arr.innerHTML;
  for (let i = 0; i < dataAux.length; i++) {
    if (dataAux[i].title == postNameShowed) {
      //Here we are storing the array with the comments of the post
      var postCommentShowed = dataAux[i].comments;
    }
  }
  //For clean the comments
  let clean = document.getElementById('comments-posts-container');
  while (clean.firstChild) {
    clean.removeChild(clean.lastChild);
  }
  //This loop is for fill the comment window
  for (let j = 0; j < postCommentShowed.length; j++) {
    //Create the container for the comment
    let cont = document.getElementById('comments-posts-container');
    let userDataComment = document.createElement('div');
    userDataComment.setAttribute('class', 'each-post2');
    //Create the picture of user
    let userImg = document.createElement('img');
    userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
    userImg.setAttribute('class', 'user-picture');
    userImg.setAttribute('alt', 'This is an user perfil picture');
    userDataComment.appendChild(userImg);

    let divusercomment = document.createElement('div');
    //Create the name of user
    let userName = document.createElement('label');
    let textUser = document.createTextNode(postCommentShowed[j].username);
    userName.setAttribute('class', 'name-user-m');
    userName.appendChild(textUser);
    divusercomment.appendChild(userName);

    //Create the comment of the user
    let commentUser = document.createElement('p');
    let texComment = document.createTextNode(postCommentShowed[j].content);
    commentUser.appendChild(texComment);
    commentUser.setAttribute('class', 'comment-user-spam');
    divusercomment.appendChild(commentUser);

    userDataComment.appendChild(divusercomment);
    //Create the button
    let button1 = document.createElement('button');
    button1.setAttribute('class', 'button-sync1');
    userDataComment.appendChild(button1);
    cont.appendChild(userDataComment);
  }
};

function activarTab(unTab) {
  try {
    //The div elements of all the tabs are all together
    //in a single cell in the second row of the tab structure table.
    //We have to find the selected one, put display block
    //and the rest put display none.
    var id = unTab.id;
    if (id) {
      var tr = unTab.parentNode || unTab.parentElement;
      var tbody = tr.parentNode || tr.parentElement;
      var table = tbody.parentNode || tbody.parentElement;
      //tabs in multiple rows
      if (table.getAttribute('data-filas') != null) {
        var filas = tbody.getElementsByTagName('tr');
        var filaDiv = filas[filas.length - 1];
        tbody.insertBefore(tr, filaDiv);
      }
      //To make it compatible with the previous version, if the table does not
      //have the data-min and data-max attributes,
      //we put the values they had before the version change.
      var desde = table.getAttribute('data-min');
      if (desde == null) desde = 0;
      var hasta = table.getAttribute('data-max');
      if (hasta == null) hasta = MAXTABS;
      var idTab = id.split('tabck-');
      var numTab = parseInt(idTab[1]);
      // "tabdiv" are the inner blocks while the "tabck"
      // are the tabs.
      var esteTabDiv = document.getElementById('tabdiv-' + numTab);
      for (var i = desde; i <= hasta; i++) {
        var tabdiv = document.getElementById('tabdiv-' + i);
        if (tabdiv) {
          var tabck = document.getElementById('tabck-' + i);
          if (tabdiv.id == esteTabDiv.id) {
            tabdiv.style.display = 'block';
            tabck.style.color = 'slategrey';
            tabck.style.backgroundColor = 'rgb(235, 235, 225)';
            tabck.style.borderBottomColor = 'rgb(235, 235, 225)';
          } else {
            tabdiv.style.display = 'none';
            tabck.style.color = 'white';
            tabck.style.backgroundColor = 'gray';
            tabck.style.borderBottomColor = 'gray';
          }
        }
      }
    }
  } catch (e) {}
}

//Tab menu Comments datatable
function setDataTableArticle(table, dataSet) {
  commentsByTopicsAuthorized= dataSet;
  table.innerHTML = '<thead style="display:none"></thead><tbody></tbody>';
  let response = [];
  var tables = $(table).DataTable({
    data: dataSet,
    columns: [{ data: 'title' }, { data: 'postcount' }, { defaultContent: "<button class='buttonComment glyphicon glyphicon-new-window' data-toggle='modal' data-target='#ModalComments'></button>" }],
    bDestroy: true,
  });

  //restart modalcontent
  let buttonCloseModal = document.getElementById('buttonCloseModal');
  buttonCloseModal.addEventListener('click', function () {
    let usercomentdata = document.getElementById('ModalCommentContent');
    while (usercomentdata.firstChild) {
      usercomentdata.removeChild(usercomentdata.lastChild);
    }
  });

  //onclick function to show modal for every row
  $('#articles tbody').on('click', 'button', function () {
    let data = tables.row($(this).parents('tr')).data();
    let title = document.querySelector('#ModalCommentTitle');
    title.innerHTML = data.title;
    pagination.querySet = data.posts;
    var dataModal = paginationModal(pagination);

    buildModal(dataModal.pageList);

    if (pagination.currentPage === 1) pageButton(pagination);

    $('.pagination-button').on('click', function () {
      $('#ModalCommentContent').empty();
      var pagination = {
        querySet: data.posts,
        pageList: new Array(),
        currentPage: pagemodal,
        numberPerPage: 10,
        numberOfPage: 0,
      };
      pagination.currentPage = $(this).val();
      let pageActive = $(this);
      pageActive.addClass('pagination-button-active');
      var dataModal = paginationModal(pagination);
      buildModal(dataModal.pageList);
    });

    $('.buttonsnextprev').on('click', function () {
      $('#ModalCommentContent').empty();
      var pagination = {
        querySet: data.posts,
        pageList: new Array(),
        currentPage: pagemodal,
        numberPerPage: 10,
        numberOfPage: 0,
      };
      let pageActive = $(this);
      pageActive.addClass('pagination-button-active');
      var dataModal = paginationModal(pagination);
      buildModal(dataModal.pageList);
    });
  });

  return tables;
}

function categoriesAuthorizedName() {
  newFetchGet(nodeBBURL + '/comments/categories-authorized', localStorage.token)
    .then((res) => {
      status = res.status;
      return res;
    })
    .then((res) => res.json())
    .then(function (res) {
      match_categoryopt_categoryauth(res);

      if (status == '403') {
        // NOT AUTHORIZED
        document.querySelector('.error-cryptofr-auth').style.display = 'block';
        return;
      }
    });
}

//DataTable Article - Modal with comments
function buildCommentsChildren(dataSet, pID) {
  let children = [];
  //first level
  for (let i = 0; i < dataSet.length; i++) {
    if (dataSet[i].pid === pID) {
      children.push(dataSet[i]);
    }
  }
  return children;
}

//--- END OF DataTable COMMENTS AND MODAL -------

function formatChildModeration(comment) {
  console.log(comment);
  let response = comment.posts[0];
  let userDataComment;

  for (let i = 0; i < response.length; i++) {
    //Create child of row in dataTable Moderation
    userDataComment = document.createElement('div');
    userDataComment.setAttribute('class', 'section-child-moderation');
    //image user
    let userImg = document.createElement('img');
    userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
    userImg.setAttribute('class', 'user-picture');
    userImg.setAttribute('alt', 'This is an user perfil picture');
    userDataComment.appendChild(userImg);
    //username
    let userName = document.createElement('label');
    let textUser = document.createTextNode(response[i].username);
    userName.setAttribute('id', response[i].pid);
    userName.setAttribute('class', 'name-user-m');
    userName.appendChild(textUser);
    userDataComment.appendChild(userName);
    //Create the comment of the user
    let commentUser = document.createElement('p');
    commentUser.setAttribute('class', 'read-more');
    let texComment = document.createTextNode(response[i].content);
    commentUser.appendChild(texComment);
    //commentUser.setAttribute("class", "comment-user");
    userDataComment.appendChild(commentUser);
    //Create the buttons
    //button red x
    let button1 = document.createElement('button');
    button1.setAttribute('class', 'buttonx-child-moderation');
    button1.setAttribute('onclick', 'clickButtonView(this)');
    userDataComment.appendChild(button1);
    //button green check
    let button2 = document.createElement('button');
    button2.setAttribute('onclick', 'clickButtonView(this)');
    button2.setAttribute('class', 'buttony-child-moderation');
    userDataComment.appendChild(button2);
    //button orange ! warning
    let button3 = document.createElement('button');
    button3.setAttribute('onclick', 'clickButtonView(this)');
    button3.setAttribute('class', 'buttonz-child-moderation');
    //userDataComment.appendChild(button3);
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' + '<tr>' + '<td>' + userImg + '</td>' + '<td>' + response[i].username + '</td>' + '<td>' + response[i].content + '</td>' + '</tr>' + '</table>';
  }
  //return userDataComment;
  // return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
  // '<tr>' +
  // '<td>'+ +'</td>' +
  // '<td>' + userDataComment + '</td>' +
  // '</tr>' +
  // '</table>';
}

//Menu  Spam tab Comments
const windowSpam = (data) => {
  if (data.length > 0) {
    //HARD CODE.
    let response = data[0][1].posts;

    //This for will fill the spam window.
    for (let k = 0; k < data.length; k++) {
      let cont = document.getElementById('inside-spam-comment');
      //console.log(cont);
      let userDataComment = document.createElement('div');
      userDataComment.setAttribute('class', 'container-spam');
      let userDataCommentBox = document.createElement('div');
      //Create the picture of user
      let userImg = document.createElement('img');
      userImg.setAttribute('src', 'https://i.blogs.es/2d5264/facebook-image/450_1000.jpg');
      userImg.setAttribute('class', 'user-picture');
      userImg.setAttribute('alt', 'This is an user perfil picture');
      userDataCommentBox.appendChild(userImg);
      //Create the name of user
      let userName = document.createElement('label');
      let textUser = document.createTextNode(response[k].username);
      userName.setAttribute('id', response[k].pid);
      userName.setAttribute('class', 'name-user-m');
      userName.appendChild(textUser);
      userDataCommentBox.appendChild(userName);
      //Create IP and email of the user
      let ipUser = document.createElement('label');
      let ipText = document.createTextNode('IP xxx xxx xx xx -thecreatorofplate@yahoo.com');
      let button0 = document.createElement('button');
      button0.setAttribute('class', 'button-spam0');

      ipUser.setAttribute('class', 'ip-user-label');
      ipUser.appendChild(ipText);
      ipUser.appendChild(button0);
      //userDataCommentBox.appendChild(ipUser);

      userDataComment.appendChild(userDataCommentBox);
      //Create the buttons
      let button1 = document.createElement('button');
      button1.setAttribute('class', 'button-spam2');
      userDataComment.appendChild(button1);
      //viewButton
      let button2 = document.createElement('button');
      button2.setAttribute('class', 'button-spam1');
      userDataComment.appendChild(button2);

      //Create the comment of the user
      let commentUser = document.createElement('p');
      let texComment = document.createTextNode(response[k].content);
      commentUser.appendChild(texComment);
      commentUser.setAttribute('class', 'comment-user-spam');
      userDataComment.appendChild(commentUser);
      cont.appendChild(userDataComment);
    }
  }
};

const selectCategoryInComments = (categories) => {
  var selectComments = document.getElementById('categoryCommentss');
  var selectSettings = document.getElementById('selectSetting');

  for (let k = 0; k < categories.length; k++) {
    var opt = document.createElement('option');
    opt.value = categories[k].option;
    opt.innerHTML = categories[k].name;

    var opt1 = document.createElement('option');
    opt1.value = categories[k].option;
    opt1.innerHTML = categories[k].name;

    selectSettings.appendChild(opt1);
    selectComments.appendChild(opt);
  }
};

const match_categoryopt_categoryauth = (cat) => {
  let categories = [];
  let cat_atuhorized = cat.categories;

  for (let i = 0; i < optionalCidsCopy.length; i++) {
    var option = parseInt(optionalCidsCopy[i]['cid']);

    for (let j = 0; j < cat_atuhorized.length; j++) {
      if (option == cat.categories[j].cid) {
        var name;

        let object = { option: option, name: cat.categories[j].name };
        categories.push(object);
        i++;
      }
    }
  }
  selectTopicsByCategoryAuth(categories);
  selectCategoryInComments(categories);
};

function selectTopicsByCategoryAuth(categories) {
  for (let k = 0; k < categories.length; k++) {
    newFetchGet(nodeBBURL + '/api/category/' + categories[k].option, localStorage.token)
      .then((res) => {
        status = res.status;
        return res;
      })
      .then((res) => res.json())
      .then(function (res) {
        topicsFilteredByDeleted(res);

        if (status == '403') {
          // NOT AUTHORIZED
          document.querySelector('.error-cryptofr-auth').style.display = 'block';
          return;
        }
      });
  }
}

const topicsFilteredByDeleted = (data) => {
  let topics = data.topics;
  let topicsAuth = [];

  for (let k = 0; k < topics.length; k++) {
    if (topics[k].deleted === 0) {
      topicsAuth.push(topics[k]);
    }
  }
  topicsAtuhorized(topicsAuth);
};

//the comments by topics for the dataTable Articles
const topicsAtuhorized = async (topics) => {
  let flag = 0;

  for (let topic of topics) {
    newFetchGet(nodeBBURL + '/api/topic/' + topic.tid + '?page=1', localStorage.token)
      .then((res) => {
        status = res.status;
        return res;
      })
      .then((res) => res.json())
      .then(function (res) {
        flag++;
        if (status != '200') {
          // NOT AUTHORIZED
          document.querySelector('.error-cryptofr-auth').style.display = 'block';
          return;
        }
        topicsByComents.push(res);
      });
  }

  while (1 == 1) {
    if (topics.length == flag) {
      setDataTableArticle(document.querySelector('#articles'), topicsByComents);
      break;
    }
    await sleep(1);
  }
};

//--When a category id is selectedCid
function selectCategoryId() {

  let button = document.getElementsByClassName('category-button');
  let cid = document.getElementById('categoryCommentss').value;

  if (cid == 'Category') {
    let button = document.getElementsByClassName('category-button');
    return false;
  }
  selectedCid(cid);
}

//When the table is filter by category
const selectedCid = (cid) => {
  $('#articles').empty();
  console.log(cid);
console.log(commentsByTopicsAuthorized);
  let response = [];

  for (let i = 0; i < commentsByTopicsAuthorized.length; i++) {
    if (commentsByTopicsAuthorized[i].cid == cid)
    response.push(commentsByTopicsAuthorized[i]);
  }
console.log(response);
  setDataTableArticle(document.querySelector('#articles'), response);
};

// ----- EVENTS

// WHEN TAB IS CHANGED IT CHECKS IF LOGIN STATE HAS CHANGE AND RELOADS THE PAGE
document.addEventListener('visibilitychange', function () {
  newFetchGet(nodeBBURL + '/comments/bycid/' + cid, localStorage.token)
    .then((res) => res.json())
    .then(function (res) {
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
    .then((res) => res.json())
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

// WHEN CLICK ON DELETE BUTTON, DELETE COMMENT FROM WINDOW SPAM
$(document).on('click', '.container-spam .button-spam1', function (e) {
  if (window.confirm('Do you really want to Delete this comment?')) {
    var parent = event.target.parentElement;
    var child = parent.getElementsByClassName('name-user-m')[0].id;

    newFetch(nodeBBURL + '/comments/delete/' + child, {}, localStorage.token).then(function () {
      //windowSpam(articles);
      location.reload();
    });
  }
});

// WHEN CLICK ON CHECK BUTTON, APROVE COMMENT FROM WINDOW SPAM
$(document).on('click', '.container-spam .button-spam2', function (e) {
  if (window.confirm('Do you really want to aprove this comment?')) {
    var parent = event.target.parentElement;
    var child = parent.getElementsByClassName('name-user-m')[0].id;
    newFetch(nodeBBURL + '/comments/approve/' + child, {}, localStorage.token).then(function () {
      //windowSpam(articles);
      location.reload();
    });
  }
});

// WHEN CLICK ON CHECK BUTTON, APROVE COMMENT FROM WINDOW MODERATION
$(document).on('click', '.section-child-moderation .buttony-child-moderation', function (e) {
  if (window.confirm('Do you really want to aprove this comment?')) {
    var parent = event.target.parentElement;
    var child = parent.getElementsByClassName('name-user-m')[0].id;
  }
});

// WHEN CLICK ON DELETE BUTTON, DELETE COMMENT FROM WINDOW MODERATION
$(document).on('click', '.section-child-moderation .buttonx-child-moderation', function (e) {
  if (window.confirm('Do you really want to Delete this comment?')) {
    var parent = event.target.parentElement;
    var child = parent.getElementsByClassName('name-user-m')[0].id;

    newFetch(nodeBBURL + '/comments/delete/' + child, {}, localStorage.token).then(function () {
      //windowSpam(articles);
      location.reload();
    });
  }
});

// WHEN CLICK ON DELETE BUTTON, DELETE COMMENT FROM COMMENTS-MODAL
$(document).on('click', '.section-complete .buttonTrashRed', function (e) {
  if (window.confirm('Do you really want to Delete this comment?')) {
    var parent = event.target.parentElement;
    var child = parent.getElementsByClassName('name-user-m')[0].id;
    newFetch(nodeBBURL + '/comments/delete/' + child, {}, localStorage.token).then(function () {
      //windowSpam(articles);
      location.reload();
    });
  } else {
    event.target.className = 'buttonTrash';
  }
});

$(document).on('click', '.section-complete .buttonWarningOrange', function (e) {
  var parent = event.target.parentElement;
  var child = parent.getElementsByClassName('name-user-m')[0].id;
  if (window.confirm('Do you really want to mark this comment as spam?')) {
    newFetch(nodeBBURL + '/comments/reject/' + child, {}, localStorage.token).then(function () {
      //windowSpam(articles);
      location.reload();
    });
  } else {
    event.target.className = 'buttonWarning';
  }
});

$(document).on('click', '.section-complete .buttonview', function (e) {
  var parent = event.target.parentElement;
  var child = parent.getElementsByClassName('name-user-m')[0].id;
  if (window.confirm('Do you really want to approve this comment?')) {
    // newFetch(nodeBBURL + '/comments/reject/' + child, {}, localStorage.token).then(function () {
    //   //windowSpam(articles);
      location.reload();
    }
  else {
    event.target.className = 'buttonViewOrange';
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
    .then((res) => res.json())
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
    .then((res) => res.json())
    .then(function (res) {
      if (res == 'false') {
        console.log('error on getblogger endpoint');
        return false;
      }
      let data = {};
      data.blogger = res.name;

      newFetch2(nodeBBURL + '/attach-single-topic/' + cid + '/' + button.getAttribute('data-post_tid') + '/' + button.getAttribute('data-id'), data, localStorage.token)
        .then((res) => res.json())
        .then(function (res) {
          if (res.ok) {
            data = {};
            data.status = 'Published';
            data.id = button.getAttribute('data-id');

            // Set the cryptofrcommment status attribute of the article in the wp database to Published or Pending
            newFetch(publishPHP, data)
              .then((res) => res.json())
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
$(document).on('click', '#export-comments', async function (event) {
  let [paginatedComments, count] = paginateExportedComments(wpComments);

  console.log('paginatedComments', paginatedComments);
  let pageCount = 1;
  for (let page of paginatedComments) {
    console.log('Exporting Comments...');
    await newFetch2(nodeBBURL + '/comments/import', page, localStorage.token)
      .then((res) => res.json())
      .then(function (res) {
        if (res.ok) {
          if (pageCount != paginatedComments.length) console.log('Done with ' + pageCount * paginationCount + ' of ' + count + ' comments');
          else console.log('Done with ' + count + ' of ' + count + ' comments');
        }
        pageCount++;

        if (!res.ok) {
          console.log('error on import endpoint');
          return false;
        }
        // location.reload();
      })
      .catch(function (error) {
        console.log('error', error);
      });
  }
});

//window.addEventListener("load",windowSpam);

window.addEventListener('load', fillPostPending);

// 'token' in localStorage && localStorage.status === '200';

// console.log('oldArticles', oldArticles);

// CHECK IF YOU ARE AUTHORIZED
if ('token' in localStorage && localStorage.status === '200') {
  var now = new Date();
  var difference = now.getTime() - new Date(localStorage.date);
  var days = Math.ceil(difference / (1000 * 3600 * 24));
  // console.log(localStorage.date);
  // console.log(now);
  // console.log(days);
  if (days >= 7) localStorage.clear();
}

if ('token' in localStorage && localStorage.status === '200') {
  (async function () {
    // GET COMMENTS FROM CATEGORY AND CATEGORIZE THEM BY ARTICLE/TOPIC
    await newFetchGet(nodeBBURL + '/comments/bycid/' + cid + '?pagination=0', localStorage.token)
      .then((res) => {
        status = res.status;
        return res;
      })
      .then((res) => res.json())
      .then(function (res) {
        data = res;
        console.log('comments data', data);

        setUSerData();

        if (status == '403') {
          hideTabsOnDashboard();
          addSocialAuthListeners(document.querySelector('#login-modal'));
          return;
        }
        displayTabsOnDashboard();
      });

    articles = groupCommentsByArticle();
    console.log('group by article', articles);
    setDataTableModeration(document.querySelector('#table_moderation'), articles);
    windowSpam(articles);

    // ALL COMMENTS table
    siteTable = setDataTableToEachArticle(articles);
    //setDataTable(document.querySelector('#grid'), data.posts);
    // Multiple articles table

    if (cid) if (!cid || cid == 0) document.querySelector('.error-cryptofr-cid').style.display = 'block';

    // Articles that are pending to be published yet
    setDataTableMarkedArticles(document.querySelector('#marked-articles-table'), markedArticles);

    // If there are old articles (before plugin installation), button to publish all the Old Articles at the same time on the CryptoFR Forum
    publishOldArticlesButton();

    // If there are old articles, button to publish all the Old Articles at the same time on the CryptoFR Forum
    attachOldArticleButton();

    //-- OPTIONAL CIDS
    getCommentsByOptionalCid();
    categoriesAuthorizedName();
  })();
} else {
  // NOT CONNECTED
  document.querySelector('#cryptofr-login').classList.add('in', 'active');
  document.querySelector('#login-modal').style.display = 'block';
  document.querySelector('#login-modal').classList.add('active');
  addSocialAuthListeners(document.querySelector('#login-modal'));
}
