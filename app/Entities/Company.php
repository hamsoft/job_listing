<?php


namespace JobListing\Entities;


use JobListing\Contracts\CurrentCompany;

/**
 * JobListing\Entities\Company
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $manager_id
 * @property string $name
 * @property string|null $description
 * @property string refresh_token
 * @property string $access_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\JobListing\Entities\JobPosition[] $jobPositions
 * @property-read \JobListing\Entities\User $manager
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereManagerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\JobListing\Entities\Company whereUpdatedAt($value)
 */
class Company extends \Eloquent implements CurrentCompany
{

    protected $table = 'companies';

    public function manager() {
        return $this->belongsTo(User::class);
    }

    public function jobPositions() {
        return $this->hasMany(JobPosition::class);
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setManager(User $user) {
        $this->manager()->associate($user);
    }

    public function getName(): string {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }

    public function getId() {
        return $this->id;
    }

    public function getRefreshToken() {
        return $this->refresh_token;
    }

    public function setAccessToken($accessToken) {
        $this->access_token = $accessToken;
    }

    public function hasGDrive(){
        return $this->access_token;
    }

}