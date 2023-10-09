<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\AvailabilityType;
use App\Course;
use App\CourseClass;
use App\CourseUfcd;
use App\HourBlock;
use App\HourBlockCourseClass;
use App\PedagogicalGroup;
use App\PedagogicalGroupUser;
use App\ScheduleAtribution;
use App\SpecializationArea;
use App\SpecializationAreaUser;
use App\TeacherAvailability;
use App\Ufcd;
use App\User;
use App\UserType;
use App\UserUfcd;

class DatabaseExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $allData = collect();

        $allData = $allData->concat(AvailabilityType::all());
        $allData = $allData->concat(Course::all());
        $allData = $allData->concat(CourseClass::all());
        $allData = $allData->concat(CourseUfcd::all());
        $allData = $allData->concat(HourBlock::all());
        $allData = $allData->concat(HourBlockCourseClass::all());
        $allData = $allData->concat(PedagogicalGroup::all());
        $allData = $allData->concat(PedagogicalGroupUser::all());
        $allData = $allData->concat(ScheduleAtribution::all());
        $allData = $allData->concat(SpecializationArea::all());
        $allData = $allData->concat(SpecializationAreaUser::all());
        $allData = $allData->concat(TeacherAvailability::all());
        $allData = $allData->concat(Ufcd::all());
        $allData = $allData->concat(User::all());
        $allData = $allData->concat(UserType::all());
        $allData = $allData->concat(UserUfcd::all());

        return $allData;
    }
}
