<div class="" style="background:#9400D3; color:#fff">
    <center>Detail Murid</center>
</div>
<dl class="dl-horizontal">
    <%
    var flag = false;
    if(obj.hasOwnProperty('approved')){
        flag = true;
%>
    <dt></dt>
    <dd><strong>
            <p class="text-error">Not Approved</p>
        </strong></dd>
    <%
    }
%>
    <%
    if(obj.hasOwnProperty('rejected')){
        flag = true;
%>
    <dt></dt>
    <dd><strong>
            <p class="text-error">Rejected</p>
        </strong></dd>
    <%
    }
%>
    <dt>ID Murid</dt>
    <dd><%= obj.student_id %></dd>
    <dt>Nama Murid</dt>
    <dd><%= obj.first_name %> <%= obj.last_name %></dd>
    <dt>Kategori Kelas</dt>
    <dd><%= obj.category %></dd>
    <dt>ID Email</dt>
    <dd><%= obj.email_id %></dd>
    <dt>Nomor Absen</dt>
    <dd><%= obj.roll_num %>/<%= obj.branch %>/<%= obj.year %></dd>

    <%
        if(!flag){
    %>
    <dt>Jumlah Yang Dipinjam</dt>
    <dd><%= obj.books_issued %></dd>
    <%
        }
    %>
</dl>

<%
    if(!flag){
        if(obj.issued_books.length > 0){
%>

<div class="" style="background:#9400D3; color:#fff">
    <center>Detail Buku Yang Dipinjam</center>
</div>

<%
            for(var book in obj.issued_books){
%>
<dl class="dl-horizontal">
    <dt>ID Peminjaman</dt>
    <dd><%= obj.issued_books[book].book_issue_id %></dd>
    <dt>Judul Buku</dt>
    <dd><%= obj.issued_books[book].name %></dd>
    <dt>Issued On</dt>
    <dd><%= obj.issued_books[book].issued_at %></dd>
</dl>
<%
            }
        }
    }
%>