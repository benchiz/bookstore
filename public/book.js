document.getElementById("bookCreateForm").addEventListener("submit", function(e) {
    e.preventDefault();

    var title = document.getElementById("title").value;
    var binding = document.getElementById("binding").value;
    var publicationDate = document.getElementById("publication_date").value;
    var bookIdentifier = document.getElementById("book_identifier").value;
    var publisher = document.getElementById("publisher").value;
    var category = document.getElementById("category").value;
    var pageCount = document.getElementById("page_count").value; 
    var price = document.getElementById("price").value;
    var author = document.getElementById("author").value;
    var genre = document.getElementById("genre").value;
    var bookstoreId = document.getElementById("bookstore_id").value;

    var submitBtn = document.getElementById("book_submit");

    var data = {
        title: title,
        binding: binding,
        publication_date: publicationDate,
        book_identifier: bookIdentifier,
        publisher: publisher,
        category: category,
        page_count: pageCount,
        price: price,
        author: author,
        genre: genre,
        bookstore_id: bookstoreId
    };

    var jsonData = JSON.stringify(data);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/src/book/create_book.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 201) {
            submitBtn.style.backgroundColor = "green";
        }
    };

    xhr.send(jsonData);
});

document.getElementById("updateBookForm").addEventListener("submit", function(e) {
    e.preventDefault();

    var idUpd = document.getElementById("id_upd").value;
    var titleUpd = document.getElementById("title_upd").value;
    var bindingUpd = document.getElementById("binding_upd").value;
    var publicationDateUpd = document.getElementById("publication_date_upd").value;
    var bookIdentifierUpd = document.getElementById("book_identifier_upd").value;
    var publisherUpd = document.getElementById("publisher_upd").value;
    var categoryUpd = document.getElementById("category_upd").value;
    var pageCountUpd = document.getElementById("page_count_upd").value; 
    var priceUpd = document.getElementById("price_upd").value;
    var authorUpd = document.getElementById("author_upd").value;
    var genreUpd = document.getElementById("genre_upd").value;
    var bookstoreIdUpd = document.getElementById("bookstore_id_upd").value;

    var updateBtn = document.getElementById("book_submit-upd");

    var dataUpdate = {
        id: idUpd,
        title: titleUpd,
        binding: bindingUpd,
        title: titleUpd,
        publication_date: publicationDateUpd,
        book_identifier: bookIdentifierUpd,
        publisher: publisherUpd,
        category: categoryUpd,
        page_count: pageCountUpd,
        price: priceUpd,
        author: authorUpd,
        genre: genreUpd,
        bookstore_id: bookstoreIdUpd
    };

    var jsonDataUpdate = JSON.stringify(dataUpdate);

    var xhrUpdate = new XMLHttpRequest();
    xhrUpdate.open("POST", "http://localhost/src/book/update_book.php", true);
    xhrUpdate.setRequestHeader("Content-Type", "application/json");

    xhrUpdate.onreadystatechange = function() {
        if (xhrUpdate.readyState === 4 && xhrUpdate.status === 200) {
            updateBtn.style.backgroundColor = "green";
        }
    };

    xhrUpdate.send(jsonDataUpdate);
});

document.getElementById("deleteBookForm").addEventListener("submit", function(e) {
    e.preventDefault();

    var idDelete = document.getElementById("id_book_delete").value;

    var deleteBtn = document.getElementById("book_delete");

    var dataDelete = {
        id: idDelete
    };

    var jsonDataDelete = JSON.stringify(dataDelete);

    var xhrDelete = new XMLHttpRequest();
    xhrDelete.open("POST", "http://localhost/src/book/delete_book.php", true);
    xhrDelete.setRequestHeader("Content-Type", "application/json");

    xhrDelete.onreadystatechange = function() {
        if (xhrDelete.readyState === 4 && xhrDelete.status === 200) {
            deleteBtn.style.backgroundColor = "green";
        }
    };

    xhrDelete.send(jsonDataDelete);
});