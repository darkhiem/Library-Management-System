// Toggle visibility of the section by ID
function toggleSection(sectionId) {
    var section = document.getElementById(sectionId);
    if (section.classList.contains('hidden')) {
        section.classList.remove('hidden');
    } else {
        section.classList.add('hidden');
    }
}

// Validate student creation form
function validateStudentForm() {
    var username = document.getElementById('new_username').value;
    var email = document.getElementById('new_email').value;
    var password = document.getElementById('new_password').value;
    
    if (username.length < 3) {
        alert('Username must be at least 3 characters long');
        return false;
    }
    
    if (!validateEmail(email)) {
        alert('Please enter a valid email address');
        return false;
    }
    
    if (password.length < 6) {
        alert('Password must be at least 6 characters long');
        return false;
    }
    
    return true;
}

// Validate email format
function validateEmail(email) {
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

// Confirm delete actions
function confirmDelete(type) {
    return confirm('Are you sure you want to delete this ' + type + '? This action cannot be undone.');
}

// Submit book search form
function submitBookSearch() {
    document.getElementById('bookSearchForm').submit();
}

// Submit student search form
function submitStudentSearch() {
    document.getElementById('studentSearchForm').submit();
}

// Filter table rows based on search input
function filterTable(inputId, tableId) {
    var input = document.getElementById(inputId);
    var filter = input.value.toUpperCase();
    var table = document.getElementById(tableId);
    var tr = table.getElementsByTagName("tr");
    
    // Loop through all table rows, and hide those that don't match the search query
    for (var i = 1; i < tr.length; i++) { // Start from 1 to skip header row
        var found = false;
        var td = tr[i].getElementsByTagName("td");
        
        for (var j = 0; j < td.length; j++) {
            var cell = td[j];
            if (cell) {
                var txtValue = cell.textContent || cell.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    found = true;
                    break;
                }
            }
        }
        
        if (found) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners for filter inputs
    var filterInputs = document.querySelectorAll('.table-filter');
    for (var i = 0; i < filterInputs.length; i++) {
        var input = filterInputs[i];
        input.addEventListener('keyup', function() {
            filterTable(this.id, this.getAttribute('data-table'));
        });
    }
    
    // Add confirm prompts to delete buttons
    var deleteButtons = document.querySelectorAll('.delete-btn');
    for (var i = 0; i < deleteButtons.length; i++) {
        var button = deleteButtons[i];
        button.addEventListener('click', function(e) {
            if (!confirmDelete(this.getAttribute('data-type'))) {
                e.preventDefault();
            }
        });
    }
});

// Calculate days remaining until due date
function calculateDaysRemaining() {
    var dueDateElements = document.querySelectorAll('.due-date');
    
    dueDateElements.forEach(function(element) {
        var dueDate = new Date(element.getAttribute('data-date'));
        var today = new Date();
        
        // Calculate days difference
        var timeDiff = dueDate.getTime() - today.getTime();
        var daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));
        
        // Set appropriate class and message based on days remaining
        var statusElement = element.nextElementSibling;
        if (daysDiff < 0) {
            statusElement.textContent = 'Overdue by ' + Math.abs(daysDiff) + ' days';
            statusElement.className = 'status-overdue';
        } else if (daysDiff <= 2) {
            statusElement.textContent = 'Due soon: ' + daysDiff + ' days left';
            statusElement.className = 'status-warning';
        } else {
            statusElement.textContent = daysDiff + ' days remaining';
            statusElement.className = 'status-good';
        }
    });
}