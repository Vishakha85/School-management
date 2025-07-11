 <!DOCTYPE html>
 <html lang="en">
 <head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>
      <link rel="stylesheet" href="{{ asset('css/login.css') }}">
 </head>
 <body>
    
    @if(count($students) > 0)
    @php $student = $students[0]; @endphp
    <form>
        @if(session('success'))
            <div style="color: green; margin-bottom: 15px;">{{ session('success') }}</div>
        @endif
        <h2>Welcome {{ session('name') }}</h2>
        <h3>Your Details</h3>
        <label>ID:</label><br>
        <input type="text" name="id" value="{{ $student->id }}" readonly disabled><br><br>

        <label>Name:</label><br>
        <input type="text" name="name" value="{{ $student->name }}" disabled><br><br>

        <label>Class:</label><br>
        <input type="text" name="class" value="{{ $student->class }}" disabled><br><br>

        <label>Number:</label><br>
        <input type="text" name="number" value="{{ $student->number }}" disabled><br><br>

        <label>Age:</label><br>
        <input type="text" name="age" value="{{ $student->age }}" disabled><br><br>

        <label>Password:</label><br>
        <input type="text" name="password" value="{{ $student->password }}" disabled><br><br>

        <a href="/students/{{ $student->id }}/edit">
            <button type="button">Edit</button>
        </a>
        <span style="display:inline-block; width: 20px;"></span>
        <a href="/logoutstd">Logout</a>
    </form>
    @else
        <p>No student data found.</p>
    @endif
   

    </body>
    </html>  