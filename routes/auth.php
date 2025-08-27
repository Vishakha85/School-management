
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Sanctum API routes
Route::post('api/login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
