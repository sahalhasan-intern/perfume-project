<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatbotProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = \App\Models\Product::query();

            if ($request->has('concern')) {
                $concernString = strtolower($request->input('concern'));
                
                // Out-of-scope topic detection
                $outOfScopeWords = ['hair', 'nail', 'teeth', 'tooth', 'stomach', 'leg', 'arm', 'foot', 'feet', 'shampoo', 'conditioner', 'perfume', 'fragrance', 'makeup', 'lipstick', 'make up'];
                foreach ($outOfScopeWords as $word) {
                    if (str_contains($concernString, $word)) {
                        return response()->json([
                            'success' => false,
                            'message' => "I specialize in ELAVA's **skincare** products. Please ask me about your skin concerns like acne, wrinkles, or dryness!"
                        ], 200); // return 200 so it displays as a normal message instead of an error boundary
                    }
                }
                
                // Add synonyms mapping to real product wording in the database
                if (str_contains($concernString, 'black circle') || str_contains($concernString, 'dark circle') || str_contains($concernString, 'eye') || str_contains($concernString, 'dark spot')) {
                    $concernString .= ' brighten vitamin glow spot even tone';
                }
                if (str_contains($concernString, 'wrinkle') || str_contains($concernString, 'aging') || str_contains($concernString, 'fine line')) {
                    $concernString .= ' aging age wrinkle retonoil';
                }
                if (str_contains($concernString, 'pimple') || str_contains($concernString, 'breakout') || str_contains($concernString, 'acne')) {
                    $concernString .= ' acne gentle impurities cleanser pore';
                }
                if (str_contains($concernString, 'dry') || str_contains($concernString, 'flaky') || str_contains($concernString, 'hydration') || str_contains($concernString, 'hydrate')) {
                    $concernString .= ' dry hydrating moisture barrier cream';
                }
                if (str_contains($concernString, 'oil') || str_contains($concernString, 'greasy') || str_contains($concernString, 'pore')) {
                    $concernString .= ' oily clay purifying pore';
                }
                if (str_contains($concernString, 'dull')) {
                    $concernString .= ' bright glow radiance vitamin';
                }
                if (str_contains($concernString, 'sensitive') || str_contains($concernString, 'redness') || str_contains($concernString, 'irritation') || str_contains($concernString, 'rosacea') || str_contains($concernString, 'compromised')) {
                    $concernString .= ' gentle soothe soothing recovery redness compromised calm';
                }
                if (str_contains($concernString, 'texture') || str_contains($concernString, 'rough') || str_contains($concernString, 'bump')) {
                    $concernString .= ' smooth exfoliate bha salicylic clear';
                }
                if (str_contains($concernString, 'pigmentation') || str_contains($concernString, 'melasma') || str_contains($concernString, 'discoloration') || str_contains($concernString, 'uneven')) {
                    $concernString .= ' vitamin bright spot even tone';
                }

                // Extract keywords and remove stopwords
                $words = explode(' ', $concernString);
                $stopwords = ['i', 'have', 'my', 'skin', 'is', 'a', 'an', 'the', 'to', 'for', 'of', 'in', 'and', 'with', 'on', 'how', 'get', 'rid', 'am', 'very', 'too', 'much', 'bad', 'some', 'got', 'has', 'from', 'help', 'need', 'want', 'looking'];
                
                $keywords = [];
                foreach ($words as $word) {
                    $word = trim($word, " .,!?");
                    if (strlen($word) > 2 && !in_array($word, $stopwords)) {
                        $keywords[] = $word;
                    }
                }
                
                // Fallback to exact string if no useful keywords extracted
                if (empty($keywords)) {
                    $keywords[] = trim($request->input('concern'));
                }

                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->orWhere('skin_concern', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('name', 'LIKE', '%' . $keyword . '%');
                    }
                });
            }

            $products = $query->take(5)->get();

            if ($products->isEmpty()) {
                $products = \App\Models\Product::inRandomOrder()->take(4)->get();
                $messagePrefix = "I couldn't find an exact match for your skin concern, but here are some of our community favorites that give your skin a beautiful healthy glow:";
            } else {
                $messagePrefix = null;
            }

            $formattedProducts = $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'skin_concern' => $product->skin_concern ?? 'General',
                    'skin_type' => $product->skin_type ?? 'All',
                    'description' => \Illuminate\Support\Str::limit($product->description, 100),
                    'image_url' => \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image),
                    'product_link' => route('product.show', $product->slug)
                ];
            });

            return response()->json([
                'success' => true,
                'message' => $messagePrefix,
                'data' => $formattedProducts
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'I am experiencing some technical difficulties right now. Please try again later.'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = \App\Models\Product::findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'skin_concern' => $product->skin_concern ?? 'General',
                    'skin_type' => $product->skin_type ?? 'All',
                    'description' => $product->description,
                    'image_url' => \Illuminate\Support\Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image),
                    'product_link' => route('product.show', $product->slug)
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }
    }
}
