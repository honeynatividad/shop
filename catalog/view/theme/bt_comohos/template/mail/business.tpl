<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd">
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>PhilCare Inc., Business Request Form</title>
    <link rel="stylesheet" href="http://memberportal2.philcare.com.ph/philcare/catalog/view/theme/bt_comohos/stylesheet/stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
<body>
  <table class="table health-tables">
    <thead class="thead-inverse">
      <tr>
        <th>Form</th>
        <th>Value</th>      
      </tr>
    </thead>
    <tbody>
      <tr>      
        <td>Full name</td>
        <td><?php echo $name ?></td>
      </tr>
      <tr>
        <td>Designation</td>
        <td><?php echo $designation ?></td>
      </tr>
      <tr>
        <td>Email Address</td>
        <td><?php echo $email ?></td>
      </tr>
      <tr>
        <td>Contact Number</td>
        <td><?php echo $contact_number ?></td>
      </tr>
      <tr>
        <td>Company Name</td>
        <td><?php echo $company ?></td>
      </tr>
      <tr>
        <td>Nature of Business</td>
        <td><?php echo $nature_of_business ?></td>
      </tr>
      <tr>
        <td>Total No of Employees</td>
        <td><?php echo $total_employees ?></td>
      </tr>
      <tr>
        <td>Total No of Dependents</td>
        <td><?php echo $total_dependents ?></td>
      </tr>
      <tr>
        <td>Annual Budget per head</td>
        <td><?php echo $annual_budget ?></td>
      </tr>
      <tr>
        <td>Do you have existing HML?</td>
        <td><?php echo $existing_hmo ?></td>
      </tr>
      <tr>
        <td>Message</td>
        <td><?php echo $message ?></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
