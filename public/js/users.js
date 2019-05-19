var startButton = document.getElementById('start');
var nextButton = document.getElementById('next');
var prevButton = document.getElementById('prev');
var searchButton = document.getElementById('search');

startButton.addEventListener('click', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/users');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('start-block').setAttribute('hidden', true);
            document.getElementById('form').removeAttribute('hidden');

            fillTable(response, 1);
        }
        else {
            alert('Ooops' + xhr.status);
        }
    };
    xhr.send();
});

prevButton.addEventListener('click', prev);
nextButton.addEventListener('click', next);
searchButton.addEventListener('click', search);

function fillTable(data) {
    var headerDivs = {
        'First name':'cell',
        'Last name':'cell',
        'Phone numbers':'cell'
    };

    var table = document.getElementById('table');
    var header = document.createElement('div');

    while (table.firstChild) {
        table.removeChild(table.firstChild);
    }

    header.className = 'row header blue';

    for (var headerDiv in headerDivs) {
        headerChild = document.createElement('div');
        headerChild.className = headerDivs[headerDiv];
        headerChild.innerHTML += headerDiv;
        header.appendChild(headerChild);
    }

    table.appendChild(header);

    size = data.length;
    for (var i = 0; i < size; i++) {
        tableChield = document.createElement('div');
        tableChield.className = 'row';
        tableChield.id = data[i].id;
        tableChield.appendChild(
            createCeil(data[i].firstName, 'First Name')
        );
        tableChield.appendChild(
            createCeil(data[i].lastName, 'Last Name')
        );
        tableChield.appendChild(
            createCeil(data[i].phoneNumbers.join(', '), 'First Name')
        );

        table.appendChild(tableChield);
    }
}

function createCeil(data, name) {
    chield = document.createElement('div');
    chield.className += 'cell';
    chield.setAttribute('data-title', name);
    chield.innerHTML += data;
    return chield;
}

function next() {
    var table = document.getElementsByClassName('table').table;
    var id = + table.lastChild.id;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/users?id=' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            fillTable(response, id);
        }
        else {
            alert('Ooops' + xhr.status);
        }
    };
    xhr.send();
}

function prev() {
    var table = document.getElementsByClassName('table').table;
    var id = table.firstChild.nextSibling.id - 30;
    var xhr = new XMLHttpRequest();

    if (id < 1) {
        id = 1;
    }

    xhr.open('GET', '/users?id=' + id);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            fillTable(response);
        }
        else {
            alert('Ooops' + xhr.status);
        }
    };
    xhr.send();
}

function search() {
    var table = document.getElementsByClassName('table').table;
    var word = document.getElementById('searchData').value;
    var id = table.firstChild.nextSibling.id;
    var xhr = new XMLHttpRequest();

    xhr.open('GET', '/users?id=' + id + '&firstName=' + word);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            fillTable(response, id);
        }
        else {
            alert('Ooops' + xhr.status);
        }
    };
    xhr.send();
}
