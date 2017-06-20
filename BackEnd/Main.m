%Akash Arora

myHexValues = {};
files = dir('*.jpeg');

% modify image data in for loop to exclude those top/bot black pixels

%Identifies where black bars stop, and passes on the number of pixels from
%top/bot that next operation must exclude
blackBarsTop = [];
blackBarsLeft = [];
%Incase of no black bars, we cannot take mode of nothing.
blackBarsTop = [blackBarsTop 0];
blackBarsLeft = [blackBarsLeft 0];

%RGB Value for black bars is assigned as the first pixel of the 37th image
isBlack = true;
imageData = imread('image-20.jpeg');
black = [imageData(1,1,1) imageData(1,1,2) imageData(1,1,3)];

%Identifty how far the black bars go into the frame top/bot
%Collect data from fourty frames
for i = 20:70
    jpegFileName = strcat('image-', num2str(i), '.jpeg');
    imageData = imread(jpegFileName);
    %Get size of the 1st dimension of imageData
    length = size(imageData,1);
    width = size(imageData,2);
    topCount = 0;
    %Determine length of Top Black Bar
    for j = 1:(length/6)
        for k = 1:100:width
            currRGB = [imageData(j,k,1) imageData(j,k,2) imageData(j,k,3)];
            %If pixel is within 5 of original black value (some black bars
            %change RGB slightly towards end)
            if (abs(currRGB(1)-black(1)) > 15 || abs(currRGB(2)-black(2)) > 15 || abs(currRGB(3)-black(3)) > 15)
                isBlack = false;
            end
        end
        %If entire row is black increase the distance from top of frame to
        %end of known black bar by one.
        if isBlack == true 
            topCount = topCount + 1;
        end
        isBlack = true;
    end
    %Append width of black bar
    blackBarsTop = [blackBarsTop topCount];

end

%Identifty how far the black bars go into the frame left/right
%Collect data from fourty frames
for i = 20:70
    jpegFileName = strcat('image-', num2str(i), '.jpeg');
    imageData = imread(jpegFileName);
    %Get size of the 1st dimension of imageData
    length = size(imageData,1);
    width = size(imageData,2);
    leftCount = 0;
    %Determine length of Left Black Bar
    for j = 1:(width/6)
        %Runs through width of film 
        for k = 1:50:length
            currRGB = [imageData(k,j,1) imageData(k,j,2) imageData(k,j,3)];
            %If pixel is within 5 of original black value (some black bars
            %change RGB slightly towards end)
            if (abs(currRGB(1)-black(1)) > 15 || abs(currRGB(2)-black(2)) > 15 || abs(currRGB(3)-black(3)) > 15)
                isBlack = false;
            end
        end
        %If entire column is black increase the distance from left of frame to
        %end of known black bar by one.
        if isBlack == true 
            leftCount = leftCount + 1;
        end
        isBlack = true;
    end
    %Append length of black bar
    blackBarsLeft = [blackBarsLeft leftCount];
end

%Use the mode of accumulated topCounts/botCounts for the 40 frames
topCount = mode(blackBarsTop);
leftCount = mode(blackBarsLeft);

%If film has no black bars, to be safe uncomment:
%topCount = 0;
%leftCount = 0;

%For reference:
%length = size(imageData,1);
%width = size(imageData,2);

%Gets average color of picture and stores as hex value in results.txt
for i = 1:numel(files)
    jpegFileName = strcat('image-', num2str(i), '.jpeg');
    imageData = imread(jpegFileName);
    %Shrink imageData to exclude black bars (Insurance = 1 pixel cut
    %top/bot/left/right)
    imageData = imageData((topCount+2):(length-topCount-1),(leftCount+2):(width-leftCount-1),:);
    Mean = mean(reshape(imageData, size(imageData,1) * size(imageData,2), size(imageData,3)));
    myHex = rgb2hex(Mean);
    myHexValues{end+1} = myHex; 
    Mean = 0;
    myHex = 0;
    imwrite(imageData,strcat(jpegFileName));
end

results = string(myHexValues);
fid = fopen('results.txt','w');
fprintf(fid,'%s\n',results);
fclose(fid);