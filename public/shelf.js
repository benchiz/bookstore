document.addEventListener("DOMContentLoaded", function() {
    loadBooks();

    document.getElementById("shelfCreateForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var category = document.getElementById("category").value;
        var placement = document.getElementById("placement").value;
        var book_id = document.getElementById("book_id").value;
        
        var submitBtn = document.getElementById("shelf-submit");
        
        var data = {
            category: category,
            placement: placement,
            book_id: book_id
        };

        var jsonData = JSON.stringify(data);

        //console.log(jsonData);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "http://localhost/src/shelf/create_shelf.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 201) {
                submitBtn.style.backgroundColor = "green";
            }
        };

        xhr.send(jsonData);
    });

    // Обработчик для обновления полки
    document.getElementById("updateShelfForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var idUpd = document.getElementById("id_upd").value;
        var categoryUpd = document.getElementById("category_upd").value;
        var placementUpd = document.getElementById("placement_upd").value;

        var updateBtn = document.getElementById("shelf_submit-upd");

        var dataUpdate = {
            id: idUpd,
            category: categoryUpd,
            placement: placementUpd
        };

        var jsonDataUpdate = JSON.stringify(dataUpdate);

        var xhrUpdate = new XMLHttpRequest();
        xhrUpdate.open("POST", "http://localhost/src/shelf/update_shelf.php", true);
        xhrUpdate.setRequestHeader("Content-Type", "application/json");

        xhrUpdate.onreadystatechange = function() {
            if (xhrUpdate.readyState === 4 && xhrUpdate.status === 200) {
                updateBtn.style.backgroundColor = "green";
            }
        };

        xhrUpdate.send(jsonDataUpdate);
    });

    document.getElementById("deleteShelfForm").addEventListener("submit", function(e) {
        e.preventDefault();

        var idDelete = document.getElementById("id_shelf_delete").value;
        var deleteBtn = document.getElementById("shelf_delete");

        var dataDelete = {
            id: idDelete
        };

        var jsonDataDelete = JSON.stringify(dataDelete);

        var xhrDelete = new XMLHttpRequest();
        xhrDelete.open("POST", "http://localhost/src/shelf/delete_shelf.php", true);
        xhrDelete.setRequestHeader("Content-Type", "application/json");

        xhrDelete.onreadystatechange = function() {
            if (xhrDelete.readyState === 4 && xhrDelete.status === 200) {
                deleteBtn.style.backgroundColor = "green";
            }
        };

        xhrDelete.send(jsonDataDelete);
    });

    function loadBooks() {
        fetch("http://localhost/src/book/get_book.php")
            .then(response => response.json())
            .then(data => {
                const bookSelect = document.getElementById("book_id");

                // Очистка выпадающего списка
                bookSelect.innerHTML = '<option value="" disabled selected>Выберите книгу</option>';
                
                data.books.forEach(book => {
                    const option = document.createElement("option");
                    option.value = book.id;
                    option.textContent = book.title;
                    bookSelect.appendChild(option);
                });
            })
            .catch(error => console.error("Ошибка при загрузке книг:", error));
    }
});