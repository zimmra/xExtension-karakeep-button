if (document.readyState && document.readyState !== 'loading')
{
  documentReady();
} else
{
  document.addEventListener('DOMContentLoaded', documentReady, false);
}

function documentReady()
{
  var readeckButtons = document.querySelectorAll('#stream .flux a.readeckButton');
  for (var i = 0; i < readeckButtons.length; i++)
  {
    let readeckButton = readeckButtons[i];
    readeckButton.addEventListener('click', function (e)
    {
      if (!readeckButton)
      {
        return;
      }

      var active = readeckButton.closest(".flux");
      if (!active)
      {
        return;
      }

      e.preventDefault();
      e.stopPropagation();

      add_to_readeck(readeckButton, active);
    }, false);
  }

  if (readeck_button_vars.keyboard_shortcut)
  {
    document.addEventListener('keydown', function (e)
    {
      if (e.ctrlKey || e.metaKey || e.altKey || e.shiftKey || e.target.closest('input, textarea'))
      {
        return;
      }

      if (e.key === readeck_button_vars.keyboard_shortcut)
      {
        var active = document.querySelector("#stream .flux.active");
        if (!active)
        {
          return;
        }

        var readeckButton = active.querySelector("a.readeckButton");
        if (!readeckButton)
        {
          return;
        }

        add_to_readeck(readeckButton, active);
      }
    });
  }
}

function add_to_readeck(readeckButton, active)
{
  var url = readeckButton.getAttribute("href");
  if (!url)
  {
    return;
  }

  let readeckButtonImg = readeckButton.querySelector("img");
  readeckButtonImg.classList.add("disabled");

  let loadingAnimation = readeckButton.querySelector(".lds-dual-ring");
  loadingAnimation.classList.remove("disabled");

  let activeId = active.getAttribute('id');

  if (pending_entries[activeId])
  {
    return;
  }

  pending_entries[activeId] = true;

  let request = new XMLHttpRequest();

  request.open('POST', url, true);
  request.responseType = 'json';

  request.onload = function (e)
  {
    delete pending_entries[activeId];

    readeckButtonImg.classList.remove("disabled");
    loadingAnimation.classList.add("disabled");

    if (this.status != 200)
    {
      return request.onerror(e);
    }

    let response = xmlHttpRequestJson(this);
    if (!response)
    {
      return request.onerror(e);
    }

    if (response.status === 202)
    {
      readeckButtonImg.setAttribute("src", readeck_button_vars.icons.added_to_readeck);
      openNotification(readeck_button_vars.i18n.added_article_to_readeck.replace('%s', response.response.title), 'readeck_button_good');
    } else
    {
      if (response.status === 404)
      {
        openNotification(readeck_button_vars.i18n.article_not_found, 'readeck_button_bad');
      } else
      {
        openNotification(readeck_button_vars.i18n.failed_to_add_article_to_readeck.replace('%s', response.errorCode), 'readeck_button_bad');
      }
    }
  };

  request.onerror = function (e)
  {
    delete pending_entries[activeId];

    readeckButtonImg.classList.remove("disabled");
    loadingAnimation.classList.add("disabled");

    badAjax(this.status == 403);
  };

  request.setRequestHeader('Content-Type', 'application/json');
  request.send(JSON.stringify({
    ajax: true,
    _csrf: context.csrf
  }));
}
