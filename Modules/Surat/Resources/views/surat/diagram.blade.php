@extends('adminlte::page')
@section('title', 'Diagram Alur Surat')
@section('content_header')
    <h1 class="m-0 text-dark">Diagram Alur Surat</h1>
@stop
@section('content')
    <script src="https://unpkg.com/gojs@3.0.8/release/go.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Poppins:regular,medium,bold&amp;subset=latin,latin-ext"
        rel="stylesheet" type="text/css">
    <style>
        #hidden {
            font: 500 18px Poppins;
            opacity: 0;
        }
    </style>
    <script id="code">
        const nameProperty = "name";
        const statusProperty = "status";
        const statusDisposisi = "status_disposisi";
        const countProperty = "count";

        const theme = {
            colors: {
                kingQueenBorder: "#FEBA00",
                civilianBorder: "#58ADA7",
                personText: "#383838",
                personNodeBackground: "#FFFFFF",
                selectionStroke: "#485670",
                counterBackground: "#485670",
                counterBorder: "#FFFFFF",
                counterText: "#FFFFFF",
                link: "#686E76",
            },
            fonts: {
                badgeFont: "bold 12px Poppins",
                nameFont: "500 20px Poppins",
                counterFont: "14px Poppins",
            },
        };
        const onMouseEnterPart = (e, part) => part.isHighlighted = true;
        const onMouseLeavePart = (e, part) => {
            if (!part.isSelected) part.isHighlighted = false;
        }
        const onSelectionChange = (part) => {
            part.isHighlighted = part.isSelected;
        }

        const STROKE_WIDTH = 3;
        const ADORNMENT_STROKE_WIDTH = STROKE_WIDTH + 1;
        const CORNER_ROUNDNESS = 12;
        const IMAGE_TOP_MARGIN = 20;
        const MAIN_SHAPE_NAME = "mainShape";
        const IMAGE_DIAMETER = 10;

        const getStrokeForStatus = (status) => {
            switch (status) {
                case "king":
                case "queen":
                    return theme.colors.kingQueenBorder;
                default:
                    return theme.colors.civilianBorder;
            }
        };

        const statusStrokeBinding = () =>
            new go.Binding("stroke", statusProperty, (status) =>
                getStrokeForStatus(status)
            );

        const highlightStrokeBinding = () =>
            new go.Binding("stroke", "isHighlighted", (isHighlighted, obj) =>
                isHighlighted ?
                theme.colors.selectionStroke :
                getStrokeForStatus(obj.part.data.status, )
            ).ofObject();
        const personCounter = () =>
            new go.Panel("Auto", {
                visible: false,
                alignmentFocus: go.Spot.Center,
                alignment: go.Spot.Bottom
            })
            .bindObject("visible", "", (obj) => obj.findLinksOutOf().count > 0)
            .add(new go.Shape("Circle", {
                desiredSize: new go.Size(29, 29),
                strokeWidth: STROKE_WIDTH,
                stroke: theme.colors.counterBorder,
                fill: theme.colors.counterBackground,
            }))
            .add(new go.TextBlock({
                    alignment: new go.Spot(0.5, 0.5, 0, 1),
                    stroke: theme.colors.counterText,
                    font: theme.fonts.counterFont,
                    textAlign: "center",
                })
                .bindObject("text", "", (obj) => obj.findNodesOutOf().count)
            )

        const personMainShape = () =>
            new go.Shape({
                figure: "RoundedRectangle",
                desiredSize: new go.Size(350, 100),
                fill: theme.colors.personNodeBackground,
                portId: "",
                parameter1: CORNER_ROUNDNESS,
                strokeWidth: STROKE_WIDTH
            })
            .bind(statusStrokeBinding())
            .bind(highlightStrokeBinding())

        const personNameTextBlock = () =>
            new go.TextBlock({
                stroke: theme.colors.personText,
                font: theme.fonts.nameFont,
                desiredSize: new go.Size(230, 50),
                overflow: go.TextOverflow.Ellipsis,
                textAlign: "center",
                verticalAlignment: go.Spot.Center,
                toolTip: go.GraphObject.build("ToolTip")
                    .add(new go.TextBlock({
                        margin: 4
                    }).bind("text", nameProperty)),
                alignmentFocus: go.Spot.Top,
                alignment: new go.Spot(0.5, 0, 0, 25)
            })
            .bind("text", nameProperty)

        const personStatusDisposisi = () =>
            new go.TextBlock({
                stroke: theme.colors.personText,
                font: theme.fonts.nameFont,
                desiredSize: new go.Size(230, 50),
                overflow: go.TextOverflow.Ellipsis,
                textAlign: "center",
                verticalAlignment: go.Spot.Center,
                toolTip: go.GraphObject.build("ToolTip")
                    .add(new go.TextBlock({
                        margin: 4
                    }).bind("text", statusDisposisi)),
                alignmentFocus: go.Spot.Top,
                alignment: new go.Spot(0.5, 0, 0, 25)
            })
            .bind("text", statusDisposisi)  

        const createNodeTemplate = () =>
            new go.Node("Spot", {
                selectionAdorned: false,
                mouseEnter: onMouseEnterPart,
                mouseLeave: onMouseLeavePart,
                selectionChanged: onSelectionChange
            })
            .add(new go.Panel("Spot")
                .add(personMainShape())
                .add(personNameTextBlock())
                .add(personStatusDisposisi())
            )
            .add(personCounter())

        const createLinkTemplate = () =>
            new go.Link({
                selectionAdorned: false,
                routing: go.Routing.Orthogonal,
                layerName: "Background",
                mouseEnter: onMouseEnterPart,
                mouseLeave: onMouseLeavePart,
                click: function(e, link) {
                    if (link.data.isReturning) {
                        // Logika kembali ke direktur atau node lainnya
                        const fromNode = diagram.findNodeForKey("Direktur"); // Misalnya, kembali ke Direktur
                        if (fromNode) {
                            link.fromNode = fromNode;
                            diagram.commit(function(d) {
                                // Perbarui model diagram setelah perubahan
                                d.model.setDataProperty(link.data, "isReturning", false); // Reset kondisi
                            });
                        }
                    }
                }
            })
            .add(new go.Shape({
                    stroke: theme.colors.link,
                    strokeWidth: 1,
                })
                .bindObject("stroke", "isHighlighted", (isHighlighted) =>
                    isHighlighted ? theme.colors.selectionStroke : theme.colors.link
                )
                .bindObject("stroke", "isSelected", (selected) =>
                    selected ? theme.colors.selectionStroke : theme.colors.link
                )
                .bindObject("strokeWidth", "isSelected", (selected) => selected ? 2 : 1)
            );

        // Fungsi untuk inisialisasi diagram
        const initDiagram = (divId, nodeDataArray, linkDataArray) => {
            if (!Array.isArray(nodeDataArray) || nodeDataArray.some(item => typeof item !== 'object' || item ===
                    null)) {
                console.error("Invalid data format for nodeDataArray");
                return;
            }
            if (!Array.isArray(linkDataArray) || linkDataArray.some(item => typeof item !== 'object' || item ===
                    null)) {
                console.error("Invalid data format for linkDataArray");
                return;
            }

            const diagram = new go.Diagram(divId, {
                layout: new go.TreeLayout({
                    angle: 90,
                    nodeSpacing: 20,
                    layerSpacing: 50,
                    layerStyle: go.TreeLayout.LayerUniform,
                    treeStyle: go.TreeStyle.LastParents,
                    alternateAngle: 90,
                    alternateLayerSpacing: 35,
                    alternateAlignment: go.TreeAlignment.BottomRightBus,
                    alternateNodeSpacing: 20
                }),
                'toolManager.hoverDelay': 100,
                linkTemplate: createLinkTemplate(),
                model: new go.GraphLinksModel({
                    nodeKeyProperty: 'key',
                    linkKeyProperty: 'key',
                    nodeDataArray: nodeDataArray,
                    linkDataArray: linkDataArray
                }),
            });

            diagram.nodeTemplate = createNodeTemplate();

            diagram.addDiagramListener('InitialLayoutCompleted', () => {
                const root = diagram.findNodeForKey("Direktur");
                if (root) {
                    diagram.scale = 0.6;
                    diagram.scrollToRect(root.actualBounds);
                }
            });
        };

        window.addEventListener("DOMContentLoaded", () => {
            const nodeData = @json($diagramNodes);
            const linkData = @json($diagramLinks);

            if (Array.isArray(nodeData) && Array.isArray(linkData)) {
                initDiagram("myDiagramDiv", nodeData, linkData);
            } else {
                console.error("Invalid data format for diagramData");
            }
        });
    </script>
    <a href="{{ url('surat/surat-masuk') }}" title="Kembali"><button class="btn btn-warning btn-sm mb-3"><i
                class="fa fa-arrow-left" aria-hidden="true"></i> Kembali</button></a>
    <div id="sample">
        <div id="myDiagramDiv"
            style="background-color: white; width: 100%; height: 550px; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;">
            <canvas tabindex="0" width="1545" height="672"
                style="position: absolute; top: 0px; left: 0px; z-index: 2; user-select: none; touch-action: none; width: 1236px; height: 538px; cursor: auto;"></canvas>
            <div style="position: absolute; overflow: auto; width: 1246px; height: 548px; z-index: 1;">
                <div style="position: absolute; width: 3786.6px; height: 771.6px;"></div>
            </div>
        </div>

        </pre>
    </div>
@endsection
