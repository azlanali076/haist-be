<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Facility extends Model
{
    use HasFactory;
    protected $table = 'facilities';
    protected $guarded = [];
    protected $appends = ['avg_dr_response_time','avg_response_time','general_total_symptoms','general_total_diseases','general_total_assessments'];

    public function users(): HasMany
    {
        return $this->hasMany(User::class,'facility_id','id');
    }

    public function admins(): HasManyThrough
    {
        return $this->hasManyThrough(User::class,FacilityAdmin::class,'facility_id','id','id','admin_id');
    }

    public function getAvgResponseTimeAttribute(){
        $facilitiesQuery = Facility::where(['facilities.id' => $this->id])
            ->leftJoin('assessments','assessments.facility_id','=','facilities.id')
            ->leftJoin('patient_symptoms','patient_symptoms.assessment_id','=','assessments.id');
        if(request()->symptom_ids and count(request()->symptom_ids) > 0){
            $facilitiesQuery->whereIn('patient_symptoms.symptom_id',request()->symptom_ids);
        }
        if(request()->disease_ids and count(request()->disease_ids) > 0){
            $facilitiesQuery->whereIn('assessments.diagnose_id',request()->disease_ids);
        }
        return $facilitiesQuery->selectRaw('AVG(TIMESTAMPDIFF(SECOND,assessments.created_at,patient_symptoms.created_at)) as response_time,facilities.id as facility_id,facilities.name as facility_name')
            ->groupBy(['facilities.id','facilities.name','patient_symptoms.id'])->first()['response_time'];
    }

    public function getGeneralTotalSymptomsAttribute(){
        $facilitiesQuery = Facility::where(['facilities.id' => $this->id])
            ->leftJoin('assessments','assessments.facility_id','=','facilities.id')
            ->leftJoin('assessment_symptoms','assessment_symptoms.assessment_id','=','assessments.id');
        if(request()->symptom_ids and count(request()->symptom_ids) > 0){
            $facilitiesQuery->whereIn('assessment_symptoms.symptom_id',request()->symptom_ids);
        }
        if(request()->disease_ids and count(request()->disease_ids) > 0){
            $facilitiesQuery->whereIn('assessments.diagnose_id',request()->disease_ids);
        }
        $totalSymptomsArr = $facilitiesQuery->selectRaw('COUNT(assessment_symptoms.id) as total_symptoms,facilities.id as facility_id,facilities.name as facility_name')
            ->groupBy(['facilities.id','facilities.name'])->first();
        if($totalSymptomsArr and isset($totalSymptomsArr['total_symptoms'])) {
            return $totalSymptomsArr['total_symptoms'];
        }
        else{
            return 0;
        }
    }

    public function getGeneralTotalDiseasesAttribute(){
        $diseasesQuery = Assessment::where(['facility_id' => $this->id])->where('status','=','Completed');
        if(request()->symptom_ids and count(request()->symptom_ids) > 0) {
            $symptomIds = request()->symptom_ids;
            $diseasesQuery->whereHas('symptoms',function($q) use ($symptomIds) {
                $q->whereIn('symptom_id',$symptomIds);
            });
        }
        if(request()->disease_ids and count(request()->disease_ids) > 0) {
            $diseasesQuery->whereIn('diagnose_id',request()->disease_ids);
        }
        return $diseasesQuery->count();
    }

    public function getGeneralTotalAssessmentsAttribute(){
        $assessmentsQuery = Assessment::where(['facility_id' => $this->id]);
        if(request()->symptom_ids and count(request()->symptom_ids) > 0) {
            $symptomIds = request()->symptom_ids;
            $assessmentsQuery->whereHas('symptoms',function($q) use ($symptomIds) {
                $q->whereIn('symptom_id',$symptomIds);
            });
        }
        if(request()->disease_ids and count(request()->disease_ids) > 0) {
            $assessmentsQuery->whereIn('diagnose_id',request()->disease_ids);
        }
        return $assessmentsQuery->count();
    }

    public function getAvgDrResponseTimeAttribute(){
        $facilitiesQuery = Facility::where(['facilities.id' => $this->id])
            ->leftJoin('assessments','assessments.facility_id','=','facilities.id')
            ->leftJoin('assessment_symptoms','assessment_symptoms.assessment_id','=','assessments.id');
        if(request()->symptom_ids and count(request()->symptom_ids) > 0){
            $facilitiesQuery->whereIn('assessment_symptoms.symptom_id',request()->symptom_ids);
        }
        if(request()->disease_ids and count(request()->disease_ids) > 0){
            $facilitiesQuery->whereIn('assessments.diagnose_id',request()->disease_ids);
        }
        return $facilitiesQuery->selectRaw('AVG(TIMESTAMPDIFF(SECOND,assessments.created_at,assessments.diagnosed_at)) as response_time,facilities.id as facility_id,facilities.name as facility_name')
            ->where('assessments.status','=','Completed')->groupBy(['facilities.id','facilities.name'])->first()['response_time'];
    }

    public function scopeBySymptomIds($query, $symptomIds = null){
        if($symptomIds) {
            $query->select(['facilities.*'])->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                ->leftJoin('assessment_symptoms','assessment_symptoms.assessment_id','=','assessments.id')
                ->whereIn('assessment_symptoms.symptom_id',$symptomIds);
        }
        return $query;
    }

    public function scopeByDiseaseIds($query, $diseaseIds = null){
        if($diseaseIds) {
            $query->select(['facilities.*'])->leftJoin('assessments','assessments.facility_id','=','facilities.id')
                ->whereIn('assessments.diagnose_id',$diseaseIds);
        }
        return $query;
    }
}
