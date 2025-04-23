@extends('theams.default')

@section('head')
<link href="{{ asset('theams/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('heading')
    عرض المستخدمين
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive"> <!-- ✅ لضمان توافق الجدول مع الشاشات الصغيرة -->
                <table id="users-table" class="table table-striped table-bordered text-right" width="100%">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>البريد الإلكتروني</th>
                            <th>نوع المستخدم</th>
                            <th>خيارات</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->isSuperAdmin() ? 'مدير عام' : ($user->isAdmin() ? 'مدير' : 'مستخدم') }}</td>
                                <td>
                                    <!-- تحديث نوع المستخدم -->
                                    <form action="{{ route('users.update', $user) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('patch')
                                        <div class="form-inline">
                                            <select name="adminstration_level" class="form-control form-control-sm">
                                                <option value="0" {{ !$user->isAdmin() && !$user->isSuperAdmin() ? 'selected' : '' }}>مستخدم</option>
                                                <option value="1" {{ $user->isAdmin() ? 'selected' : '' }}>مدير</option>
                                                <option value="2" {{ $user->isSuperAdmin() ? 'selected' : '' }}>مدير عام</option>
                                            </select>
                                            <button type="submit" class="btn btn-info btn-sm ml-2">
                                                <i class="fa fa-edit"></i> تعديل
                                            </button>
                                        </div>
                                    </form>

                                    <!-- حذف المستخدم -->
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        @if (auth()->user()->id !== $user->id)
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد؟')">
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        @else
                                            <button class="btn btn-danger btn-sm disabled" disabled>
                                                <i class="fa fa-trash"></i> حذف
                                            </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- ✅ إغلاق div -->
        </div>
    </div>
@endsection

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('theams/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theams/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json',
                },
            });
        });
    </script>
@endsection
