<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Notifications\TicketConfirmationNotification;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTicketRequest;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\TicketMappedInventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Priority;
use App\Status;
use App\Ticket;
use App\User;
use Gate;
use App\Inventory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TicketsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::with(['status', 'priority', 'category', 'assigned_to_user', 'comments','inventories','technicalPerson'])
                ->filterTickets($request)
                ->select(sprintf('%s.*', (new Ticket)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'ticket_show';
                $editGate = 'ticket_edit';
                $deleteGate = 'ticket_delete';
                $crudRoutePart = 'tickets';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('inventory_id', function ($row) {
                return $row->inventory_id ? $row->inventory_id : "";
            });
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : "";
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });
            $table->addColumn('status_color', function ($row) {
                return $row->status ? $row->status->color : '#000000';
            });

            $table->addColumn('priority_name', function ($row) {
                return $row->priority ? $row->priority->name : '';
            });
            $table->addColumn('priority_color', function ($row) {
                return $row->priority ? $row->priority->color : '#000000';
            });

            $table->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->name : '';
            });
            $table->addColumn('category_color', function ($row) {
                return $row->category ? $row->category->color : '#000000';
            });

            $table->editColumn('author_name', function ($row) {
                return $row->author_name ? $row->author_name : "";
            });
            $table->editColumn('author_email', function ($row) {
                return $row->author_email ? $row->author_email : "";
            });
            $table->addColumn('assigned_to_user_name', function ($row) {
                return $row->assigned_to_user ? $row->assigned_to_user->name : '';
            });
            $table->addColumn('assign_to_technical_person', function ($row) {
                return $row->technicalPerson ? $row->technicalPerson->name : '';
            });

            $table->addColumn('comments_count', function ($row) {
                return $row->comments->count();
            });

            $table->addColumn('view_link', function ($row) {
                return route('admin.tickets.show', $row->id);
            });
            $table->addColumn('inventory_names', function ($row) {
                return $row->inventories->pluck('product_name')->implode(', '); // Adjust `product_name` to your Inventory table column
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'priority', 'category', 'assigned_to_user','inventory_names']);

            return $table->make(true);
        }

        $priorities = Priority::all();
        $statuses = Status::all();
        $categories = Category::all();

        return view('admin.tickets.index', compact('priorities', 'statuses', 'categories'));
    }

    public function create()
    {
        abort_if(Gate::denies('ticket_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inventories = Inventory::all()->pluck('inventory_id', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_to_users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $users = User::whereHas('roles', function ($query) {
            $query->where('title', 'Technical Person');
        })->get();


        return view('admin.tickets.create', compact('statuses', 'priorities', 'categories', 'assigned_to_users', 'inventories', 'users'));
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create($request->all());
        foreach ($request->input('attachments', []) as $file) {
            $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
        }

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created successfully, and confirmation email sent!');

    }

    public function edit(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = Status::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $priorities = Priority::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $categories = Category::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inventories = Inventory::all()->pluck('product_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $assigned_to_users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $ticket->load('status', 'priority', 'category', 'assigned_to_user');
        $users = User::whereHas('roles', function ($query) {
            $query->where('title', 'Technical Person');
        })->get();

        return view('admin.tickets.edit', compact('statuses', 'priorities', 'categories', 'assigned_to_users', 'ticket', 'inventories', 'users'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
//        $ticket->update($request->all());
        DB::beginTransaction();

        try {

            $ticketData = [
                'title' => $request->title,
                'content' => $request->content,
                'status_id' => $request->status_id,
                'priority_id' => $request->priority_id,
                'category_id' => $request->category_id,
                'author_name' => $request->author_name,
                'author_email' => $request->author_email,
                'assigned_to_user_id' => $request->assigned_to_user_id,
                'assign_to_technical_person_id' => $request->assign_to_technical_person_id,
            ];
            $ticket->update($ticketData);

            // Update ticket attachments
            if (count($ticket->attachments) > 0) {
                foreach ($ticket->attachments as $media) {
                    if (!in_array($media->file_name, $request->input('attachments', []))) {
                        $media->delete();
                    }
                }
            }

            $media = $ticket->attachments->pluck('file_name')->toArray();

            foreach ($request->input('attachments', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $ticket->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('attachments');
                }
            }


            $inventoryIds = $request->input('inventory_ids', []);


            $existingInventoryIds = TicketMappedInventory::where('ticket_id', $ticket->id)
                ->pluck('inventory_id')
                ->toArray();


            $inventoryIdsToRemove = array_diff($existingInventoryIds, $inventoryIds);
            $inventoryIdsToAdd = array_diff($inventoryIds, $existingInventoryIds);

            // Remove outdated inventory mappings
            if (!empty($inventoryIdsToRemove)) {
                TicketMappedInventory::where('ticket_id', $ticket->id)
                    ->whereIn('inventory_id', $inventoryIdsToRemove)
                    ->delete();
            }



            foreach ($inventoryIdsToAdd as $inventoryId) {
                $existingMapping = TicketMappedInventory::where('inventory_id', $inventoryId)->exists();
                if ($existingMapping) {
                    throw new \Exception("Inventory ID {$existingMapping->product_name} is already mapped to another ticket.");
                }
                TicketMappedInventory::create([
                    'inventory_id' => $inventoryId,
                    'ticket_id' => $ticket->id,
                    'status' => 1,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.tickets.index')->with('success', 'Ticket updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }

    }

    public function show(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->load('status', 'priority', 'category', 'assigned_to_user', 'comments', 'inventory','inventories','technicalPerson');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function destroy(Ticket $ticket)
    {
        abort_if(Gate::denies('ticket_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ticket->delete();

        return back();
    }

    public function massDestroy(MassDestroyTicketRequest $request)
    {
        Ticket::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'comment_text' => 'required'
        ]);
        $user = auth()->user();
        $comment = $ticket->comments()->create([
            'author_name' => $user->name,
            'author_email' => $user->email,
            'user_id' => $user->id,
            'comment_text' => $request->comment_text
        ]);

        $ticket->sendCommentNotification($comment);

        return redirect()->back()->withStatus('Your comment added successfully');
    }
}
