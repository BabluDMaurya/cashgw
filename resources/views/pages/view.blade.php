<html>
   
   <head>
      <title>View Student Records</title>
   </head>
   
   <body>
      <table border = 1>
         <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Email</td>
            <td>Subject</td>
            <td>Message</td>
         </tr>
         @foreach ($users as $user)
         <tr>
            <td>{{ $user->id }}</td>
            <td>{{ decrypt($user->name) }}</td>
            <td>{{ decrypt($user->email) }}</td>
            <td>{{ decrypt($user->subject) }}</td>
            <td>{{ decrypt($user->message) }}</td>
         </tr>
         @endforeach
      </table>
   </body>
</html>