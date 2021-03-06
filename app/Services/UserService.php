<?php

namespace App\Services;

use App\DTO\ImageDTO;
use App\DTO\UserDTO;
use App\Events\UserRegistered;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\UserSearchRepository;
use App\Services\Image\ImageService;
use App\Services\Interfaces\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;

class UserService implements UserServiceInterface
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    public function slideAuthors()
    {
        try {
            $authors = $this->userRepository->showAllUsers(User::SLIDE_PER_PAGE);
            return $authors;
        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Service',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }

        

    }

    public function searchUsers(array $queryParams)
    {
        try {
            $repository = new UserSearchRepository;

            $repository->makeQuery($queryParams['filters']);
            $repository->orderBy($queryParams['order']);

            return $repository->paginateSearch($queryParams['paginate']);
        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Service',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }



    }
    

    public function findUserById(int $id)
    {
        try {
            
            $repository = new UserRepository;

            return $repository->findUserById($id);

        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Service',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }
    }

    public function findUserByEmail(string $email)
    {
        try {
            
            $repository = new UserRepository;

            return $repository->retrieveUserByEmail($email);

        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Service',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }
    }


    public function create(array $attributes)
    {
        try {
            $userDTO = new UserDTO;

            $imageDTO = new ImageDTO;

            $imageService = new ImageService(app('firebase.storage'));

            $imageAttr = [
                'file' => $attributes['file'],
                'id' => null,
                'folder' => 'user'
            ];


            $uploadImage = $attributes['file'] ? $imageService->uploadImage($imageDTO, $imageAttr) : ['name' => 'user-photos/user.png'];

            $attributes['detail']['photo'] = $uploadImage['name'];

            $user = $this->userRepository->create($userDTO, $attributes);

            if(is_null($user)) {
                throw new Exception("Has been ocurred error when proceed to register user");
            }

            event(new UserRegistered($user));

            return $user;

        } catch (Exception $e) {

            Log::error($e->getMessage(), [
                'LEVEL' => 'Repository',
                'TRACE' => $e->getTrace()
            ]);

            throw $e;
        }
    }

    public function updateUser(array $attributes, int $userId)
    {
        try {
            $userDTO = new UserDTO;

            $user = $this->userRepository->updateUser($userDTO, $attributes, $userId);

            return $user;
        } catch (Exception $e) {
            Log::error($e->getMessage(),[
                'LEVEL' => 'Repository',
                'TRACE' => $e->getTrace()//ponerlo asi a todos
            ]);

            throw $e;
        }

    }

}
