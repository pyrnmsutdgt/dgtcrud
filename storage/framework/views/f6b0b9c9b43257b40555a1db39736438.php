<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบลงทะเบียนเรียน (Database Project)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="text-primary"><i class="fas fa-university"></i> ระบบลงทะเบียนเรียน</h2>
                <p class="text-muted">ตัวอย่างการใช้ SQL View ร่วมกับ Laravel</p>
                <a href="<?php echo e(route('report.index')); ?>" class="btn btn-sm btn-info text-white">
                    <i class="fas fa-file-alt"></i> รายงานตามรายวิชา
                </a>
            </div>
            <div class="col-md-4 text-end">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createModal">
    <i class="fas fa-plus"></i> ลงทะเบียนเพิ่ม
</button>

<button type="button" class="btn btn-outline-primary ms-2" data-bs-toggle="modal" data-bs-target="#createStudentModal">
    <i class="fas fa-user-plus"></i> เพิ่มนักศึกษาใหม่
</button>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>รหัสนักศึกษา</th>
                            <th>ชื่อนักศึกษา</th>
                            <th>คณะ</th>
                            <th>วิชา</th>
                            <th>อาจารย์ผู้สอน</th>
                            <th>เกรด</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><span class="badge bg-secondary"><?php echo e($row->student_code); ?></span></td>
                            <td>
                                <a href="<?php echo e(route('students.show', $row->student_id)); ?>" class="text-decoration-none fw-bold"> 
                                    <?php echo e($row->student_name); ?> <i class="fas fa-external-link-alt fa-xs text-muted"></i>
                                </a>
                            </td>
                            <td><small class="text-muted"><?php echo e($row->department_name); ?></small></td>
                            <td>
                                <strong><?php echo e($row->course_code); ?></strong><br>
                                <?php echo e($row->course_name); ?>

                            </td>
                            <td><?php echo e($row->instructor_name); ?></td>
                            <td>
                                <?php if($row->grade): ?>
                                    <span class="badge bg-primary"><?php echo e($row->grade); ?></span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">รอเกรด</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editModal<?php echo e($row->enrollment_id); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                
                                <form action="<?php echo e(route('enrollments.destroy', $row->enrollment_id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('ยืนยันการถอนรายวิชา?');">
                                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal<?php echo e($row->enrollment_id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php echo e(route('enrollments.update', $row->enrollment_id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">บันทึกเกรด: <?php echo e($row->student_name); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <label>วิชา: <?php echo e($row->course_code); ?> <?php echo e($row->course_name); ?></label>
                                            <div class="mt-2">
                                                <label class="form-label">เลือกเกรด</label>
                                                <select name="grade" class="form-select">
                                                    <option value="">-- รอตัดเกรด --</option>
                                                    <?php $__currentLoopData = ['A', 'B+', 'B', 'C+', 'C', 'D', 'F']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($g); ?>" <?php echo e($row->grade == $g ? 'selected' : ''); ?>><?php echo e($g); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">บันทึก</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('enrollments.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">ลงทะเบียนรายวิชาใหม่</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">นักศึกษา</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">-- เลือกนักศึกษา --</option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s->id); ?>"><?php echo e($s->student_code); ?> - <?php echo e($s->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">วิชาที่ลงทะเบียน</label>
                            <select name="course_id" class="form-select" required>
                                <option value="">-- เลือกวิชา --</option>
                                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($c->id); ?>"><?php echo e($c->code); ?> - <?php echo e($c->name); ?> (<?php echo e($c->credits); ?> หน่วยกิต)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-success">ลงทะเบียน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="<?php echo e(route('students.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มฐานข้อมูลนักศึกษา</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">รหัสนักศึกษา</label>
                        <input type="text" name="student_code" class="form-control" required placeholder="เช่น 661234">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ชื่อ-นามสกุล</label>
                        <input type="text" name="name" class="form-control" required placeholder="เช่น นายรักเรียน เพียรศึกษา">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">สังกัดคณะ</label>
                        <select name="department_id" class="form-select" required>
                            <option value="">-- เลือกคณะ --</option>
                            <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($dept->id); ?>"><?php echo e($dept->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH C:\laragon\www\dgtcrud\resources\views/enrollments/index.blade.php ENDPATH**/ ?>