console.log("crud.js loaded");
const urlBase = 'http://proctest.jaxontopel.xyz/LAMPAPI';
const extension = 'php';

// NOTE: this need to be modified to include current user id so the 
//appropriate contacts are displayed.
//Also, the url may need to be changed



function fetchContacts() {
    let url = urlBase + '/alternatelist.' + extension;

    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                console.error("Error:", data.error);
            } else {
                populateTable(data.results); // Pass the results to populate the table
            }
        })
        .catch(error => console.error("Error fetching contacts:", error));
}

function populateTable(contacts) {
    const tableBody = document.getElementById("contacts-table");
    tableBody.innerHTML = ""; // Clear existing rows

    contacts.forEach(contact => {
        const row = document.createElement("tr");

        row.innerHTML = `
            <td>${contact.name}</td>
            <td>${contact.email}</td>
            <td>${contact.phone}</td>
        `;

        tableBody.appendChild(row); // Append each contact to the table
    });
}



document.addEventListener("DOMContentLoaded", function () {
    let navigateAddContactButton = document.getElementById("navigateAddContact");
    
    if (navigateAddContactButton) {
        navigateAddContactButton.addEventListener("click", function() {
            window.location.href = "add_contact.html"; 
        });
    } else {
        console.error("navigateAddContactButton button not found.");
    }
    readCookie();
    fetchContacts();
});


document.addEventListener("DOMContentLoaded", function () {
    let addContactButton = document.getElementById("addContactButton");

    if (addContactButton) {
	addContactButton.addEventListener("click", function () {
	    console.log("add contact userId:", userId);
	    addContact();
	});
    }

    let navigateBackButton = document.getElementById("navigateBack");
    if (navigateBackButton) {
	navigateBackButton.addEventListener("click", function () {
	    window.location.href = "contacts.html";
	});
    }
});

function addContact() {
    let name = document.getElementById("contactName").value;
    let email = document.getElementById("contactEmail").value;
    let phone = document.getElementById("contactPhone").value;
   

    if (!name || !email || !phone) {
	document.getElementById("contactResult").innerHTML = "All fields are required.";
	return;
    }

    let tmp = { name: name, email: email, phone: phone, userId: userId };
    let jsonPayload = JSON.stringify(tmp);
    let url = urlBase + "/AddContact." + extension;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

    try {
	xhr.onreadystatechange = function () {
	    if (xhr.readyState == 4 && xhr.status == 200) {
		document.getElementById("contactResult").innerHTML = "Contact added successfully!";
		document.getElementById("addContactForm").reset(); // Clear form fields
	    }
	};
	xhr.send(jsonPayload);
    } catch (err) {
	document.getElementById("contactResult").innerHTML = "Error adding contact.";
    }
}

function readCookie()
{
	userId = -1;
	let data = document.cookie;
    console.log("User ID from Cookie: ", userId);   // Check userId
	let splits = data.split(",");
	for(var i = 0; i < splits.length; i++) 
	{
		let thisOne = splits[i].trim();
		let tokens = thisOne.split("=");
		if( tokens[0] == "firstName" )
		{
			firstName = tokens[1];
		}
		else if( tokens[0] == "lastName" )
		{
			lastName = tokens[1];
		}
		else if( tokens[0] == "userId" )
		{
			userId = parseInt( tokens[1].trim() );
		}
	}
	
	if( userId < 0 )
	{
		window.location.href = "index.html";
	}
	else
	{
//		document.getElementById("userName").innerHTML = "Logged in as " + firstName + " " + lastName;
	}
}

function addContact() {
	console.log("in addContact");

	
}
