var startButton = document.getElementById('start');

startButton.addEventListener('click', function () {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/users');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            document.getElementById('start-block').setAttribute('hidden', true);
            document.getElementById('form').removeAttribute('hidden');

            fillTable(response);
        }
        else {
            alert('Ops' + xhr.status);
        }
    };
    xhr.send();
});

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

    for (var i = 0; i < data.length; i++) {
        tableChield = document.createElement('div');
        tableChield.className = 'row';
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