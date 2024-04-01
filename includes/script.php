<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/smooth-scrollbar.min.js"></script>
<script src="../../assets/js/plugins/datatables.js"></script>
<script src="../../assets/js/plugins/dragula.min.js"></script>
<script src="../../assets/js/plugins/jkanban/jkanban.js"></script>
<script src="../../assets/js/custom.js"></script>
<script src="../../assets/js/sweetalert.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!--  Plugin for the Wizard -->
<script src="../../assets/js/gsdk-bootstrap-wizard.js"></script>

<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
<script src="../../assets/js/jquery.validate.min.js"></script>
<script src="../../assets/js/plugins/chartjs.min.js"></script>

 <!-- Plugin for icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">


<script>
  var win = navigator.platform.indexOf('Win') > -1;
  if (win && document.querySelector('#sidenav-scrollbar')) {
    var options = {
      damping: '0.5'
    }
    Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
  }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->

<script>
  $(document).ready(function() {
    $('#datatable-search').DataTable( {
        "bDestroy": true

    } );
} );

</script>




<script src="../../assets/js/material-dashboard.min.js"></script>

<?php
include '../../includes/graph-data.php';
?>
<!-- Analytics Insights ( Work Status ) -->
<script>
  var ctx1 = document.getElementById("chart-consumption").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    new Chart(ctx1, {
      type: "doughnut",
      data: {
        labels: ['Full time', 'Part time', 'Self Employed', 'Unemployed'],
        datasets: [{
          label: "Consumption",
          weight: 9,
          cutout: 90,
          tension: 0.9,
          pointRadius: 2,
          borderWidth: 2,
          backgroundColor: ['#FF0080', '#9E9E9E', '#03A9F4', '#fcba03',],
          data: [<?php echo $total_ft; ?> , <?php echo $total_pt; ?> , <?php echo $total_se; ?> , <?php echo $total_ue; ?> ],
          fill: false
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            }
          },
        },
      },
    });
</script>
<!-- End of Analytics Insights ( Work Status ) -->

<!-- Analytics Insights ( Per Department ) -->
<script>
  var ctx1 = document.getElementById("chart-consumption2").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    new Chart(ctx1, {
      type: "doughnut",
      data: {
        labels: ['CS Department', 'BA Department', 'EDUC Department', 'HM Department', 'LA Department', 'ENG Department', 'NURS Department'],
        datasets: [{
          label: "Consumption",
          weight: 9,
          cutout: 90,
          tension: 0.9,
          pointRadius: 2,
          borderWidth: 2,
          backgroundColor: ['#FF0080', '#9E9E9E', '#03A9F4', '#4CAF50', '#fcba03', '#090706', '#F6360C'],
          data: [<?php echo $total_CS; ?>, <?php echo $total_BA; ?>, <?php echo $total_EDUC; ?> , <?php echo $total_HM; ?>, <?php echo $total_LA; ?>, <?php echo $total_ENG; ?>, <?php echo $total_NURS; ?>],
          fill: false
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              display: false,
            }
          },
        },
      },
    });
</script>
<!-- End of Analytics Insights ( Per Department ) -->

<script src="https://cdn.datatables.net/plug-ins/1.13.1/api/fnReloadAjax.js"></script>
<!-- Script Table of Alumni Form List -->
  

  <script>
// $(document).ready(function () {
//   var table = $('#searchTable').DataTable({
//         "ajax": {
//           "url": "userData/ctrl.table_alumni-form.php",
//           "dataSrc": ""
//           },
//         "columns": [
//           { "data": 'form_id',
//               "render": function (data, type, row) {
//                 if ($("#all").is(":checked")) {
//                   return '<div class="form-check"><input class="form-check-input checkAll" type="checkbox" value="'+data+'" name="checkRow[]" id="row'+data+'" checked></div>';
//       } else {
//         return '<div class="form-check"><input class="form-check-input checkAll" type="checkbox" value="'+data+'" name="checkRow[]" id="row'+data+'"></div>';
//       }
//       } 
//     },

//             { "data": 'image',
//               "render": function (data, type, row) {
//                 if (data) {
// return '<img class=" border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="data:image/jpeg;base64,' + data + '" "/>';
//                 } else {
//                   return '<img class="border-radius-lg shadow-sm zoom" style="height:80px; width:80px;" src="../../assets/img/image.png"/>';
//                 }
//       }
//              },
//             { "data": 'stud_no' },
//             { "data": 'fullname' },
//             { "data": 'batch' },
//             { "data": 'course_abv' },
//             { "data": 'current_title' },
//             { "data": 'status' },
//             { "data": 'email' },
//             { "data": 'contact' },
//             { "data": 'form_id',
//               "render": function (data, type, row) {
//                if ("<?php echo $_SESSION['role']; ?>" == "Super Administrator" ||  "<?php echo $_SESSION['role']; ?>" == "Admin") {
// return ' <td class="text-sm font-weight-normal"><a class="btn btn-link text-success px-3 mb-0" href="view-data.php?formID='+data+'"><i class="material-icons text-sm me-2">visibility</i>View</a><a class="btn btn-link text-danger text-gradient px-3 mb-0" href="../alumni/userData/ctrl-del-form.php?formID='+data+'"><i class="material-icons text-sm me-2"  >delete</i>Delete</a></td>';
//                 } else if ("<?php echo $_SESSION['role'] ?>" == "Registrar") {
//  return ' <td class="text-sm font-weight-normal"><a class="btn btn-link text-success px-3 mb-0" href="javascript:;"><i class="material-icons text-sm me-2">visibility</i>View</a></td>'; }
//                 }
//              },
          
//         ],

//         "columnDefs": [
//     { "orderable": false, "targets": 0 }
//   ]
//     });

//  $("#all").click(function () {
//       if ($("#all").is(":checked")) {
//         table.ajax.reload();
//       } else {
//         table.ajax.reload();
//       }
//     });
    
// });

  </script>
  <!-- End Table of Alumni Form List -->

<!-- Script for Alumni Form Table -->
<script>
  $(function () {
    var table = $('#searchTable').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });

    table.buttons().container().appendTo('#searchTable_wrapper .col-md-6:eq(0)');
  });
</script>

  <!-- DataTables CSS -->
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<!-- Your existing HTML code -->

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.8/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function () {
    $("#searchTable").DataTable();
  });
</script>

</body>
</html>

<!-- End Script for Alumni Form Table -->


  <!-- Update View Count on News -->
<script>
    function updateViewCount(newsId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'update-view-count.php?id=' + newsId, true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Update the displayed view count
            var viewCountElement = document.getElementById('viewCount_' + newsId);
            if (viewCountElement) {
                viewCountElement.textContent = parseInt(viewCountElement.textContent) + 1;
            }
        }
    };

    xhr.send();
}
</script>
  <!-- End of Update View Count on News -->

<!-- Satisfaction Graph -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php
        $sql = "SELECT rating FROM tbl_feedback";
        $result = $db->query($sql);

        $feedbackData = [0, 0, 0, 0, 0];
        $totalRatings = 0;

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rating = $row['rating'];
                $feedbackData[$rating - 1]++;
                $totalRatings += $rating;
            }
        }

        // Calculate the mean rating
        $meanRating = $totalRatings / ($result->num_rows ?: 1);
        ?>

        var ctx = document.getElementById("chart-bars").getContext("2d");

        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["5", "4", "3", "2", "1"],
                datasets: [
                    {
                        label: "Feedback Ratings",
                        data: <?php echo json_encode(array_reverse($feedbackData)); ?>,
                        backgroundColor: '#FEE12B',
                        borderColor: 'rgba(0, 0, 0, 0)',
                        borderWidth: 1,
                        categoryPercentage: 0.7,
                        barPercentage: 0.9, 
                    },
                ],
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        max: <?php echo max($feedbackData) + 1; ?>,
                        grid: {
                            display: false, 
                        },
                        ticks: {
                            display: false,
                        },
                    },
                    y: {
                        grid: {
                            display: false, 
                        },
                        ticks: {
                            display: true,
                            padding: 15, 
                        },
                    },
                },
                indexAxis: 'y',
            },
        });

        var meanDisplay = document.getElementById('meanDisplay');
        meanDisplay.textContent = 'Rating: ' + <?php echo $meanRating; ?>.toFixed(2);
    });
</script>
<!-- End of Satisfaction Graph -->

<!-- Job Alignment Analytics -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php
        $sql = "SELECT align_id FROM tbl_form WHERE align_id IN (1, 2)";
        $result = $db->query($sql);

        $alignmentData = [0, 0];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $align = $row['align_id'];
                $alignmentData[$align - 1]++;
            }
        }

        // Calculate the percentage of align_id 1 over align_id 2 and round it to a whole number
        $percentage = round(($alignmentData[0] / ($alignmentData[0] + $alignmentData[1])) * 100);
        ?>

        var ctx = document.getElementById("chart-bars2").getContext("2d");

        var myChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["Aligned", "Not Aligned"],
                datasets: [
                    {
                        label: "Job Alignment",
                        data: <?php echo json_encode($alignmentData); ?>,
                        backgroundColor: ['#3853ff', '#2a3ebf'], 
                        borderColor: 'rgba(0, 0, 0, 0)',
                        borderWidth: 1,
                        categoryPercentage: 0.7,
                        barPercentage: 0.5, 
                    },
                ],
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true,
                        max: <?php echo max($alignmentData) + 1; ?>,
                        grid: {
                            display: false, 
                        },
                        ticks: {
                            display: true,
                        },
                    },
                    y: {
                        grid: {
                            display: false, 
                        },
                        ticks: {
                            display: true,
                            padding: 15, 
                        },
                    },
                },
                indexAxis: 'x',
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });

        var percentageDisplay = document.getElementById('percentageDisplay');
        percentageDisplay.textContent = 'Percentage of Employed Graduates with Jobs Aligned with their Course: ' + <?php echo $percentage; ?> + '%';
    });
</script>
<!-- End of Job Alignment Analytics -->
