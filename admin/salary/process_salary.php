<?php
include("../../system_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
  $employee_id = $_POST['employee'];
  $selected_month = $_POST['month'];
  $employee_details = getuser_byID($employee_id);
  $month = date('m', strtotime($selected_month));
  $year = date('Y', strtotime($selected_month));
  $total_working_days = getTotalWorkingDaysByEmpId($employee_id, $year, $month);
  $getAllPointsByEmpId = getAllPointsByEmpId($employee_id, $year, $month, $employee_details['user_type']);
  // pr($config['user_type'][$employee_details['user_type']]);exit;
  // pr($getAllPointsByEmpId);exit;
  $html = '<section class="content">
    <div class="box box-info">
    <form id="form" name="form" action="' . SITEPATH . 'admin/salary/calculate_salary.php" method="post" enctype="multipart/form-data">
                <div class="box-body">
                <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Employee Details</h4>
                </div>
                </div>
                <input id="data_id" name="data_id" type="hidden" value="' . $employee_id . '" />
                <input id="selected_month" name="selected_month" type="hidden" value="' . $selected_month . '" />
        
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" id="first_name" readonly name="first_name" placeholder="" value="' . $employee_details['first_name'] . '" type="text" />
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" id="user_email" readonly name="user_email" placeholder="" value="' . $employee_details['user_email'] . '" type="text" />
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>Mobile Number</label>
                        <input class="form-control" id="user_phone" readonly name="user_phone" placeholder="" value="' . $employee_details['user_phone'] . '" type="text" />
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label>User Role</label>
                    <select id="user_type" disabled name="user_type" class="form-control">';
  foreach ($config['user_type'] as $key => $value) {
    if ($key == 1) {
      continue;
    }
    $selected = ($key == $employee_details['user_type']) ? ' selected="selected"' : '';
    $html .= '<option ' . $selected . ' value="' . $key . '">' . $value . '</option>';
  }
  $html .= '</select>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                    <h4 class="divd">Salary Details</h4>
                    </div>
                </div>


              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <label>Basic Salary</label>
                  <input class="form-control" name="basic_salary" step="1" onchange="sumOfTotalSalary();" min="0" placeholder="Basic Salary" value="' . $employee_details['basic_salary'] . '" type="number">
                </div>
              </div>

              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <label>Petrol</label>
                  <input class="form-control" name="petrol" step="1" min="0" onchange="sumOfTotalSalary();" placeholder="Petrol Expense" value="' . $employee_details['petrol'] . '" type="number">
                </div>
              </div>

              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <label>Mobile Recharge</label>
                  <input class="form-control" name="mobile_recharge" step="1" onchange="sumOfTotalSalary();" min="0" placeholder="Mobile Recharge Expense" value="' . $employee_details['mobile_recharge'] . '" type="number">
                </div>
              </div>

              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <label>Extra Allowance</label>
                  <input class="form-control" name="extra_allowance" step="1" onchange="sumOfTotalSalary();" min="0" placeholder="Extra Allowance" value="' . $employee_details['extra_allowance'] . '" type="number">
                </div>
              </div>

              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                  <label>Working Target(Point)</label>
                  <input class="form-control" name="working_target" onchange="calculateTotalPoint();" min="0" placeholder="Working Target (Point)" value="' . $employee_details['working_target'] . '" type="number">
                </div>
              </div>

              <div class="col-sm-2 col-md-2 col-lg-2">
                <div class="form-group">
                    <label>Total Working Days</label>
                    <input class="form-control" step="0.5" name="total_working_days" min="0" placeholder="Working Target (Point)" value="' . $total_working_days . '" type="number">
                </div>
              </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12">
                <h4 class="divd">Salary Calculation</h4>
                </div>
            </div>';

  $totalPoint = 0;

  foreach ($getAllPointsByEmpId as $key => $totalCount) {
    $totalPoint += $totalCount;
    $html .= '<div class="col-sm-2 col-md-2 col-lg-2">
                                                                          <div class="form-group">
                                                                              <label>' . $key . '</label>
                                                                              <input class="form-control" onchange="calculateTotalPoint();" name="' . $key . '" min="0" placeholder="' . $key . '" value="' . $totalCount . '" type="number">
                                                                          </div>
                                                                          </div>';
  }

  $salary = $employee_details['petrol'] + $employee_details['mobile_recharge'] + $employee_details['extra_allowance'];
  $basic_salary = $employee_details['basic_salary'];
  $working_target = $employee_details['working_target'];

  $percentageAchieved = ($totalPoint / $employee_details['working_target']) * 100;
  $percentageAchieved = min($percentageAchieved, 100);
  $totalCalculateSalary = $salary * ($percentageAchieved / 100);

  // Calculate totalCalculateSalary
  if ($percentageAchieved < 30) {
    $totalCalculateSalary = $salary;
    $totalPercentageOfTheSalary = 0;
  } else if ($totalPoint > $employee_details['working_target']) {
    $excessPoints = $totalPoint - $employee_details['working_target'];
    $excessSalary = $excessPoints * ($basic_salary / $employee_details['working_target']);
    $totalCalculateSalary = $salary + $excessSalary;
    $totalPercentageOfTheSalary = $excessSalary;
  } else {
    $totalCalculateSalary = $salary + ($basic_salary * ($percentageAchieved / 100));
    $totalPercentageOfTheSalary = $basic_salary * ($percentageAchieved / 100);
  }


  $html .= '<div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Achieved Total Point</label>
                <input class="form-control"  name="total_point" readonly min="0" placeholder="Total Point" value="' . $totalPoint . '" type="number">
            </div>
          </div>


            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Incentive</label>
                <input class="form-control" step="1" name="other_pay_amount" onchange="calculateSalary();" min="0" placeholder="Incentive" type="number">
            </div>
            </div>

            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Other Deduction</label>
                <input class="form-control" step="1" name="other_deduction" onchange="calculateSalary();" min="0" placeholder="Other Deduction" type="number">
            </div>
            </div>

            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Advance Pay</label>
                <input class="form-control" step="1" name="advance_pay" onchange="calculateSalary();" min="0" placeholder="Advance Pay" type="number">
            </div>
            </div>

            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Leave Amount</label>
                <input class="form-control" step="1" name="leave_amount" onchange="calculateSalary();" min="0" placeholder="Leave Amount" type="number">
            </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Basic Salary Amount(%)</label>
                <input class="form-control" readonly step="1" name="total_calculated_salary_percentage" min="0" placeholder="Total Point" value="' . $totalPercentageOfTheSalary . '" type="number">
            </div>
            </div>

            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Total Calculated Salary</label>
                <input class="form-control" step="1" readonly name="total_calculated_salary" min="0" placeholder="Total Calculated Salary" value="' . ($totalCalculateSalary) . '" type="number">
            </div>
            </div>

            <div class="col-sm-2 col-md-2 col-lg-2">
            <div class="form-group">
                <label>Total Salary</label>
                <input class="form-control" step="1" readonly name="total_salary" onchange="calculateSalary();" min="0" placeholder="Total Salary" value="' . ($salary + $basic_salary) . '" type="number">
            </div>
            </div>

                       
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <div class="form-group">
                <label>Description</label>
                <input class="form-control" maxlength="500" name="descriptions" placeholder="Write something here........" type="text">
              </div>
            </div>

            <div class="text-center">
            <button type="submit" class="btn btn-danger">Generate Salary</button>
            </div>
            </div>';

  $html .= '</form> </div></section>';

  echo $html;
} else {
  echo "Invalid request";
  die;
}
