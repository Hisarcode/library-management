<div class="" style="background:#9400D3; color:#fff">
    <center>Detail Buku</center>
</div>
<dl class="dl-horizontal">
    <dt>Judul Buku</dt>
    <dd><%= obj.book_name %></dd>
    <dt>Pengarang</dt>
    <dd><%= obj.author %></dd>
    <dt>Book Category</dt>
    <dd><%= obj.category %></dd>
    <dt>Status</dt>
    <dd><%= obj.available_status %></dd>
    <dt>Tanggal Buku Ditambahkan</dt>
    <dd><%= obj.updated_at %></dd>
</dl>

<%
    if(obj.hasOwnProperty('student')){
%>
<div class="" style="background:#9400D3; color:#fff">
    <center>Detail Murid</center>
</div>
<dl class="dl-horizontal">
    <dt>ID Murid</dt>
    <dd><%= obj.student.student_id %></dd>
    <dt>Nama Murid</dt>
    <dd><%= obj.student.first_name %> <%= obj.student.last_name %></dd>
    <dt>Kategori Kelas</dt>
    <dd><%= obj.student.category %></dd>
    <dt>Nomor Absen</dt>
    <dd><%= obj.student.roll_num %></dd>
</dl>
<%
    }
%>